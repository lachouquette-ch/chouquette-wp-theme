const loadGoogleMapsApi = require('load-google-maps-api');

const GOOGLE_MAPS_KEY = 'AIzaSyCL4mYyxlnp34tnC57WyrU_63BJhuRoeKI';

export const Z_INDEX_SELECTED = 1000;
export const Z_INDEX_CHOUQUETTISE = 500;
export const Z_INDEX_DEFAULT = 100;

export const ZOOM_LEVEL_DEFAULT = 15;
export const ZOOM_LEVEL_ACTIVED = 17;

export const SWITZERLAND_BOUNDS = {
    north: 48.5744540832,
    south: 45.3980935767,
    west: 4.3880763722,
    east: 11.93019063
};
export const MAP_STYLES = {
    "featureType": "poi.business",
    "stylers": [
        {"visibility": "off"}
    ]
};

export default class Map {
    static loadGoogleMapsApi() {
        return loadGoogleMapsApi({key: GOOGLE_MAPS_KEY});
    }

    static createMap(googleMaps, mapElement) {
        return new googleMaps.Map(mapElement, {
            zoom: ZOOM_LEVEL_DEFAULT,
            clickableIcons: false,
            disableDefaultUI: true,
            fullscreenControl: true,
            gestureHandling: 'greedy',
            restriction: {
                latLngBounds: SWITZERLAND_BOUNDS,
                strictBounds: false,
            },
            styles: MAP_STYLES,
            center: {
                lat: 46.519962,
                lng: 6.633597
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            }
        });
    }

    static bounceMarker(marker) {
        if (marker.getAnimation()) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
            window.setTimeout(function () {
                marker.setAnimation(null);
            }, 2000);
        }
    };
}