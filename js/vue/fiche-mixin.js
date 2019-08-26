const VUE_FICHE_MIXIN = {
    methods: {
        ficheFlip: function (element) {
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
            const mapContainer = $('#ficheMap' + fiche.attr("data-fiche-id"));
            if (mapContainer.children().length === 0) {
                // get fiche data from parent attributes
                const ficheId = fiche.attr("data-fiche-id");
                const ficheName = fiche.attr("data-fiche-name");
                const ficheLat = parseFloat(fiche.attr("data-fiche-lat"));
                const ficheLng = parseFloat(fiche.attr("data-fiche-lng"));
                const fichePosition = (ficheLat && ficheLng) ? {lat: ficheLat, lng: ficheLng} : null;
                const ficheIcon = fiche.attr("data-fiche-icon");

                if (fichePosition) {
                    var ficheMap = new google.maps.Map(mapContainer.get(0), {
                        center: fichePosition,
                        clickableIcons: false,
                        disableDefaultUI: true,
                        gestureHandling: "none",
                        restriction: {
                            latLngBounds: SWITZERLAND_BOUNDS,
                            strictBounds: false,
                        },
                        scaleControl: true,
                        styles: MAP_STYLES,
                        zoom: 18,
                        zoomControl: true
                    });
                    // add marker
                    new google.maps.Marker({
                        animation: google.maps.Animation.DROP,
                        clickable: false,
                        icon: fiche.attr("data-fiche-icon"),
                        map: ficheMap,
                        position: fichePosition,
                        title: fiche.attr("data-fiche-name"),
                    });
                }
            }
        }
    },
    mounted: function () {
        // handle fiche heights
        var self = this;
        $('.fiche').each(function (index, element) {
            // compute each fiche height
            var frontHeight = $(element).find('.fiche-front .card').outerHeight();
            var backHeight = $(element).find('.fiche-back .card').outerHeight();

            if (frontHeight > backHeight) {
                $('.fiche, .fiche-back .card').height(frontHeight);
            } else {
                $('.fiche, .fiche-front .card').height(backHeight);
            }

            // add mouse gesture
            var mc = new Hammer(element);
            mc.on("swipeleft swiperight", function() {
                self.ficheFlip(element);
            });
        });
    }
};