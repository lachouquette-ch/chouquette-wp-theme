const MAP_STYLES = [
    {
        "featureType": "poi.business",
        "stylers": [
            {"visibility": "off"}
        ]
    },
];

const SWITZERLAND_BOUNDS = {
    north: 48.5744540832,
    south: 45.3980935767,
    west: 4.3880763722,
    east: 11.93019063
};
const LAUSANNE_LOCALISATION = {
    lat: 46.519962,
    lng: 6.633597
};

const Z_INDEX_SELECTED = 1000;
const Z_INDEX_CHOUQUETTISE = 500;
const Z_INDEX_DEFAULT = 100;

const ZOOM_LEVEL_ACTIVED = 17;

function bounce(marker) {
    if (marker.getAnimation()) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
        window.setTimeout(function () {
            marker.setAnimation(null);
        }, 2000);
    }
};