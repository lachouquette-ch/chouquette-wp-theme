var map = null; // google map

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

    google.maps.event.addListener(map, "click", function (event) {
        app.clearMap();
        if (app.markers.size > 1) map.fitBounds(app.bounds);
    });

    app.addFichesToMap();
};

var app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIAS_MIXIN, VUE_UTILITY_MIXIN],
    data() {
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
            axios({
                method: 'get',
                url: this.ficheApiURL + location.search,
            })
                .then(function (response) {
                    app.bounds = new google.maps.LatLngBounds();
                    response.data.forEach(function (fiche) {
                        // create info window
                        var infoWindow = new google.maps.InfoWindow({content: fiche.infoWindow});
                        app.infoWindows.set(fiche.id, infoWindow);

                        // create marker
                        if (_.isEmpty(fiche.location)) {
                            console.log(`${fiche.title} has no location`);
                            return;
                        }

                        var marker = new google.maps.Marker({position: fiche.location, icon: fiche.icon, map: map});
                        marker.defaultZIndex = fiche.chouquettise ? Z_INDEX_CHOUQUETTISE : Z_INDEX_DEFAULT;
                        marker.setZIndex(marker.defaultZIndex); // to start
                        app.markers.set(fiche.id, marker);
                        app.bounds.extend(marker.getPosition());

                        // action on marker
                        marker.addListener('click', function () {
                            // only for column display
                            if (app._colEnabled()) {
                                // goto fiche
                                var elmnt = document.getElementById('target' + fiche.id);
                                elmnt.scrollIntoView(true, {behavior: "smooth"});
                            }

                            // work on map
                            app.clearMap();
                            app.currentMarker = this;
                            app.currentMarker.setZIndex(Z_INDEX_SELECTED);
                            app.currentInfoWindow = infoWindow;
                            app.currentInfoWindow.open(map, app.currentMarker);
                        });
                    });

                    if (app.markers.size > 1) {
                        map.fitBounds(app.bounds);
                    } else if (app.markers.size) {
                        map.setCenter(app.markers.values().next().value.getPosition());
                    }
                });
        },
        // locate on fiche on the map, display info window and activate animation
        locateFiche: function (ficheId) {
            this.clearMap();

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

            // for mobile
            if (!this._colEnabled()) {
                window.scrollTo(0, 0);
            }
        }
    },
    mounted() {
        // get selections
        var selectedLocation = document.getElementById("search-loc");
        this.location = selectedLocation.options[selectedLocation.selectedIndex].value;
        var selectCategory = document.getElementById("search-cat");
        this.category = selectCategory.options[selectCategory.selectedIndex].value;
        this.refreshCriterias(this.category);

        if (this.category) {
            this.ficheApiURL = `http://chouquette.test/wp-json/cq/v1/category/${this.category}/fiche`;
        } else {
            this.ficheApiURL = `http://chouquette.test/wp-json/cq/v1/location/${this.location}/fiche`;
        }

        // scroll to current fiche
        var num = this.$_params.get('num');
        if (num) {
            var numGotoFiche = num - CQ_CATEGORY_PAGING_NUMBER;
            // compute first fiche to go to
            var fiche = document.getElementsByClassName("fiches-map-fiche")[numGotoFiche];
            setTimeout(function () {
                fiche.childNodes[0].scrollIntoView(true, {behavior: "smooth"});
            }, 1500);
        }
    }
});