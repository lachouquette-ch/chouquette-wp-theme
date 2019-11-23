/* Bootstrap imports (once) */
import 'popper.js';
import 'lettering.js';
import 'bootstrap';

import Vue from 'vue';
import $ from 'jquery';
import buildAndStartSwiper from "./misc/swiper";

$(function () {
    const swiper = buildAndStartSwiper();
});

const app = new Vue({
    el: '#app',
    data: {
        loc: '',
        cat: '',
        search: ''
    },
    computed: {
        // helper to create proper grid columns
        action() {
            if (this.cat) {
                return 'category/' + this.cat;
            } else if (this.loc) {
                return 'location/' + this.loc;
            }
        },
        searchName() {
            return (this.cat || this.loc) ? 'search' : 's';
        }
    },
    methods: {
        doSearch() {
            $("select[name='cat']").attr('disabled', true);
        },
    }
});