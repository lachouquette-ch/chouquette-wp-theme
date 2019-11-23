import '../partials/fiche-modals';

import $ from 'jquery';
import Hammer from 'hammerjs';

import GoogleMaps from '../misc/map';

const VUE_FICHE_MIXIN = {
    methods: {
        ficheFlip(element) {
            var fiche;
            if ($(element).hasClass('fiche')) {
                fiche = $(element);
            } else {
                fiche = $(element).parents('.fiche');
            }

            // flip card
            if (fiche.hasClass('flipped') == false) {
                fiche.find('.fiche-back').css('transform', 'rotateY(0deg)');
                fiche.find('.fiche-front').css('transform', 'rotateY(180deg)');
            } else {
                fiche.find('.fiche-back').css('transform', 'rotateY(180deg)');
                fiche.find('.fiche-front').css('transform', 'rotateY(0deg)');
            }
            fiche.toggleClass('flipped');

            // create map if none
            const mapContainer = fiche.find(".fiche-map");
            if (mapContainer.children().length === 0) {
                this.bootstrapFicheMap(fiche);
            }
        },
        bootstrapFicheMap(ficheElement) {
            // get map container
            const mapContainer = ficheElement.find(".fiche-map");

            // get fiche data from parent attributes
            const ficheId = ficheElement.attr("data-fiche-id");
            const ficheName = ficheElement.attr("data-fiche-name");
            const ficheLat = parseFloat(ficheElement.attr("data-fiche-lat"));
            const ficheLng = parseFloat(ficheElement.attr("data-fiche-lng"));
            const fichePosition = (ficheLat && ficheLng) ? {lat: ficheLat, lng: ficheLng} : null;
            const ficheIcon = ficheElement.attr("data-fiche-icon");

            if (fichePosition) {
                GoogleMaps.loadGoogleMapsApi()
                    .then(googleMaps => {
                        const ficheMap = GoogleMaps.createMap(googleMaps, mapContainer.get(0));
                        ficheMap.setOptions({
                            gestureHandling: "none",
                            fullscreenControl: false
                        });

                        // add marker
                        const ficheMarker = new google.maps.Marker({
                            animation: google.maps.Animation.DROP,
                            clickable: false,
                            icon: ficheIcon,
                            map: ficheMap,
                            position: fichePosition,
                            title: ficheName,
                        });
                        ficheMap.setCenter(ficheMarker.getPosition());
                    });
            }
        }
    },
    mounted() {
        // handle fiche heights
        var self = this;
        $('.fiche').each((index, element) => {
            // compute each fiche height
            var frontHeight = $(element).find('.fiche-front .card').height();
            var backHeight = $(element).find('.fiche-back .card').height();

            if (frontHeight > backHeight) {
                $(element).height(frontHeight);
                $(element).find('.fiche-back .card').height(frontHeight);
            } else {
                $(element).height(backHeight);
                $(element).find('.fiche-front .card').height(backHeight);
            }

            // add mouse gesture
            var mc = new Hammer(element);
            mc.on("swipeleft swiperight", function () {
                self.ficheFlip(element);
            });
        });
    }
};

export default VUE_FICHE_MIXIN;