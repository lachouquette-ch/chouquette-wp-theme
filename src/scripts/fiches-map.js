require('./partials/fiche-modals');

import Vue from 'vue';
import $ from 'jquery';
import axios from 'axios';
import MarkerClusterer from '@google/markerclusterer';

import GoogleMaps, * as MapConst from './misc/map';
import VUE_CRITERIA_MIXIN from "./vue/criteria-mixin";
import VUE_UTILITY_MIXIN from "./vue/utility-mixin";
import VUE_FICHE_MIXIN from "./vue/fiche-mixin";

let map;
$(function () {
    let mapElement = document.getElementById('fichesMap');

    GoogleMaps.loadGoogleMapsApi()
        .then(googleMaps => {
            map = GoogleMaps.createMap(googleMaps, mapElement);

            google.maps.event.addListenerOnce(map, "tilesloaded", () => {
                var legend = $("#fichesMapLegend").children(0);
                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend.get(0));
                var reset = $("#fichesMapReset").children(0);
                map.controls[google.maps.ControlPosition.LEFT_TOP].push(reset.get(0));
            });

            app.addFichesToMap();
        });
});

const app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIA_MIXIN, VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    data: function () {
        return {
            category: null,
            location: null,
            ficheApiURL: '',
            currentMarker: null,
            markers: new Map(),
            currentInfoWindow: null,
            infoWindows: new Map(),
            bounds: null
        }
    },
    methods: {
        updateCriterias: function (event) {
            var value = event.target.value;
            this.refreshCriterias(value ? value : this.category);
        },
        resetMap: function () {
            this.clearMap();

            if (app.markers.size > 1) {
                map.fitBounds(app.bounds);
            } else if (app.markers.size) { // single marker
                app.currentMarker = app.markers.values().next().value;
                map.setCenter(app.currentMarker.getPosition());

                app.currentInfoWindow = app.infoWindows.values().next().value;
                app.currentInfoWindow.open(map, app.currentMarker);
            }
        },
        toggleMap: function () {
            $(".category-map").toggleClass("open");
            $(".category-map > button").attr('aria-expanded', function (i, attr) {
                return attr == 'true' ? 'false' : 'true'
            });
        },
        // stop current animation and close current info window
        clearMap: function () {
            if (app.currentMarker) {
                // stop animation
                app.currentMarker.setAnimation(null);
                // reset zindex
                app.currentMarker.setZIndex(app.currentMarker.defaultZIndex);
            }

            if (app.currentInfoWindow) app.currentInfoWindow.close();
            // reset index
        },
        // get fiches from URL and add it to map
        addFichesToMap: function () {
            axios.get(this.ficheApiURL + location.search)
                .then(function (response) {
                    app.bounds = new google.maps.LatLngBounds();
                    response.data.forEach(function (fiche) {
                        // create marker
                        if ($.isEmptyObject(fiche.location)) {
                            $("#" + fiche.id + " button").hide();
                            return;
                        }

                        // create info window
                        var infoWindow = new google.maps.InfoWindow({content: fiche.infoWindow});
                        app.infoWindows.set(fiche.id, infoWindow);

                        var marker = new google.maps.Marker({position: fiche.location, icon: fiche.icon});
                        marker.defaultZIndex = fiche.chouquettise ? MapConst.Z_INDEX_CHOUQUETTISE : MapConst.Z_INDEX_DEFAULT;
                        marker.setZIndex(marker.defaultZIndex); // to start
                        app.markers.set(fiche.id, marker);
                        app.bounds.extend(marker.getPosition());

                        // action on marker
                        marker.addListener('click', function () {
                            // only for column display
                            if (app._colEnabled()) {
                                app.highlightFiche(fiche.id);
                            }

                            // work on map
                            app.clearMap();
                            app.currentMarker = this;
                            app.currentMarker.setZIndex(MapConst.Z_INDEX_SELECTED);
                            app.currentInfoWindow = infoWindow;
                            app.currentInfoWindow.open(map, app.currentMarker);
                        });
                    });

                    // add marker clusterer
                    new MarkerClusterer(map, Array.from(app.markers.values()), {imagePath: CQ_IMG_PATH + '/maps_cluster/m'});
                })
                .then(function () {
                    // reset
                    app.resetMap();
                });
        },
        // highlight fiche on fiches list
        highlightFiche: function (ficheId) {
            // only for mobile
            if (!app._colEnabled() && $("#fichesMap").is(":visible")) { // must be on mobile view
                this.toggleMap();
            }

            // remove highlights
            $("article.fiche").removeClass("highlight");

            // goto fiche
            var elmnt = document.getElementById('target' + ficheId);
            elmnt.scrollIntoView(true, {behavior: "smooth"});
            elmnt.parentElement.classList.add("highlight");
        },
        // locate on fiche on the map, display info window and activate animation
        locateFiche: function (ficheId) {
            this.clearMap();

            if (!app._colEnabled() && !$("#fichesMap").hasClass("open")) { // must be on mobile view
                this.toggleMap();
            }

            // remove highlights
            $("article.fiche").removeClass("highlight");

            app.currentMarker = app.markers.get(ficheId);
            // zoom and center map
            map.setZoom(MapConst.ZOOM_LEVEL_ACTIVED);
            map.setCenter(app.currentMarker.getPosition());
            // set zIndex
            app.currentMarker.setZIndex(MapConst.Z_INDEX_SELECTED);
            // start animation
            GoogleMaps.bounceMarker(app.currentMarker);

            // close current infoWindow
            app.currentInfoWindow = app.infoWindows.get(ficheId);
            app.currentInfoWindow.open(map, app.currentMarker);
        }
    },
    mounted: function () {
        // get selections
        this.location = document.getElementById("search-loc").value;
        this.category = document.getElementById("search-cat").value;
        this.refreshCriterias(this.category);

        if (this.category) {
            this.ficheApiURL = '/wp-json/cq/v1/category/' + this.category + '/fiche';
        } else {
            this.ficheApiURL = '/wp-json/cq/v1/location/' + this.location + '/fiche';
        }

        // scroll to current fiche
        var num = this.$_params.get('num');
        if (num) {
            var numGotoFiche = num - CQ_CATEGORY_PAGING_NUMBER;
            // compute first fiche to go to
            var fiche = document.getElementsByClassName("fiche")[numGotoFiche];
            setTimeout(function () {
                fiche.childNodes[0].scrollIntoView(true, {behavior: "smooth"});
            }, 1500);
        }

        $(".category-map > button").delay(1000).queue(function (next) {
            $(this).css('right', '-130px');
            next();
        });
    }
});