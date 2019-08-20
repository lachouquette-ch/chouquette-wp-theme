var map = null; // google map
var mapIsLoaded = false;

function bootstrapMap() {
    map = new google.maps.Map(document.getElementById('fichesMap'), {
        zoom: 15,
        disableDefaultUI: true,
        fullscreenControl: true,
        gestureHandling: 'greedy',
        restriction: {
            latLngBounds: SWITZERLAND_BOUNDS,
            strictBounds: false,
        },
        styles: MAP_STYLES,
        center: LAUSANNE_LOCALISATION
    });

    google.maps.event.addListenerOnce(map, "tilesloaded", function (event) {
        var legend = $("#fichesMapLegend").children(0);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend.get(0));
        var reset = $("#fichesMapReset").children(0);
        map.controls[google.maps.ControlPosition.LEFT_TOP].push(reset.get(0));
    });

    app.addFichesToMap();
};

var app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIAS_MIXIN, VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
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
            $(".category-map-toggle").toggleClass("open");
            $(".category-map-toggle button").attr('aria-expanded', function (i, attr) {
                return attr == 'true' ? 'false' : 'true'
            });
            $("#fichesMap").toggle();

            if (!mapIsLoaded) { // for first load
                this.resetMap();
                mapIsLoaded = true;
            }
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
                        // create info window
                        var infoWindow = new google.maps.InfoWindow({content: fiche.infoWindow});
                        app.infoWindows.set(fiche.id, infoWindow);

                        // create marker
                        if (_.isEmpty(fiche.location)) {
                            $("#" + fiche.id + " button").hide();
                            return;
                        }

                        var marker = new google.maps.Marker({position: fiche.location, icon: fiche.icon});
                        marker.defaultZIndex = fiche.chouquettise ? Z_INDEX_CHOUQUETTISE : Z_INDEX_DEFAULT;
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
                            app.currentMarker.setZIndex(Z_INDEX_SELECTED);
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
            // goto fiche
            var elmnt = document.getElementById('target' + ficheId);
            elmnt.scrollIntoView(true, {behavior: "smooth"});
        },
        // locate on fiche on the map, display info window and activate animation
        locateFiche: function (ficheId) {
            this.clearMap();

            if (!app._colEnabled() && !$("#fichesMap").is(":visible")) { // must be on mobile view
                this.toggleMap();
            }

            app.currentMarker = app.markers.get(ficheId);
            // zoom and center map
            map.setZoom(ZOOM_LEVEL_ACTIVED);
            map.setCenter(app.currentMarker.getPosition());
            // set zIndex
            app.currentMarker.setZIndex(Z_INDEX_SELECTED);
            // start animation
            bounce(app.currentMarker);

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
    }
});