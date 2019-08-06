function bootstrapMap() {
    map = new google.maps.Map(document.getElementById('fichesMap'), {
        zoom: 15,
        disableDefaultUI: true,
        gestureHandling: 'cooperative',
        restriction: {
            latLngBounds: SWITZERLAND_BOUNDS,
            strictBounds: false,
        },
        styles: MAP_STYLES,
    });

    google.maps.event.addListener(map, "click", function (event) {
        app.clearFiches(true);
        if (app.markers.size > 1) map.fitBounds(app.bounds);
    });

    app.addLocationsToMap();
};

var app = new Vue({
    el: '#app',
    data() {
        return {
            locations: new Map(),
            markers: new Map(),
            post: null,
            bounds: null,
            currentMarker: null,
            currentLocation: null
        }
    },
    computed: {
        // helper to show/hide fiche
        showLocation: function (id) {
            return true;
        }
    },
    methods: {
        addLocationsToMap: function () {
            axios({
                method: 'get',
                url: `/wp-json/cq/v1/post/${this.post}/location`,
            })
                .then(function (response) {
                    app.bounds = new google.maps.LatLngBounds();
                    response.data.forEach(function (loc) {
                        var marker = new google.maps.Marker({position: loc, icon: loc.icon, map: map});
                        app.markers.set(loc.id, marker);
                        app.locations.set(loc.id, loc);
                        app.bounds.extend(marker.getPosition());

                        // action on marker
                        marker.addListener('click', function () {
                            app.clearFiches();

                            // set currentLocation and toggle
                            if (app.currentMarker != this) {
                                app.currentLocation = loc;
                                $(`#ficheContent${app.currentLocation.id}`).collapse('toggle');

                                app.currentMarker = this;
                                map.setZoom(ZOOM_LEVEL_ACTIVED);
                                map.setCenter(app.currentMarker.getPosition());
                                bounce(app.currentMarker);
                            } else {
                                if (app.currentLocation) {
                                    $(`#ficheContent${app.currentLocation.id}`).collapse('toggle');
                                }

                                app.currentMarker = null;
                                app.currentLocation = null;
                            }
                        });
                    });

                    app.clearFiches();
                });
        },
        // stop current animation and close fiches
        clearFiches: function () {
            if (this.currentMarker) {
                this.currentMarker.setAnimation(null);
            }

            if (this.markers.size > 1) {
                map.fitBounds(this.bounds);
            } else if (this.markers.size) {
                map.setCenter(this.markers.values().next().value.getPosition());
            }
        },
        // locate on fiche on the map and activate animation
        locateFiche: function (ficheId) {
            this.clearFiches(false);

            targetLocation = this.locations.get(ficheId);
            if (targetLocation != this.currentLocation) {
                this.currentLocation = targetLocation;
                // no need to toggle fiche, bootstrap does that already

                this.currentMarker = this.markers.get(ficheId);
                map.setZoom(ZOOM_LEVEL_ACTIVED);
                map.setCenter(this.currentMarker.getPosition());
                bounce(this.currentMarker);
            } else {
                this.currentMarker = null;
                this.currentLocation = null;
            }
        },
    },
    mounted() {
        this.post = $("article").attr('id');
    }
})