const VUE_FICHE_MIXIN = {
    methods: {
        ficheFlip: function (event) {
            const parent = $(event.target).parents('.fiche');

            // flip card
            if (parent.hasClass('flipped') == false) {
                parent.find('.fiche-back').css('transform', 'rotateY(0deg)');
                parent.find('.fiche-front').css('transform', 'rotateY(180deg)');
            } else {
                parent.find('.fiche-back').css('transform', 'rotateY(180deg)');
                parent.find('.fiche-front').css('transform', 'rotateY(0deg)');
            }
            parent.toggleClass('flipped');

            // create map if none
            const mapContainer = $('#ficheMap' + parent.attr("data-fiche-id"));
            if (mapContainer.children().length === 0) {
                // get fiche data from parent attributes
                const ficheId = parent.attr("data-fiche-id");
                const ficheName = parent.attr("data-fiche-name");
                const ficheLat = parseFloat(parent.attr("data-fiche-lat"));
                const ficheLng = parseFloat(parent.attr("data-fiche-lng"));
                const fichePosition = (ficheLat && ficheLng) ? {lat: ficheLat, lng: ficheLng} : null;
                const ficheIcon = parent.attr("data-fiche-icon");

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
                        icon: parent.attr("data-fiche-icon"),
                        map: ficheMap,
                        position: fichePosition,
                        title: parent.attr("data-fiche-name"),
                    });
                }
            }
        }
    },
}