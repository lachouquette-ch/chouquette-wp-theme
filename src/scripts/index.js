import Vue from 'vue';
import $ from 'jquery';
import buildAndStartPostSwiper from "./misc/swiper";

$(function () {
    const swiper = buildAndStartPostSwiper();
});

const app = new Vue({
    el: '#app',
    data: function () {
        return {
            loc: '',
            cat: '',
            search: ''
        }
    },
    computed: {
        // helper to create proper grid columns
        action: function () {
            if (this.cat) {
                return 'category/' + this.cat;
            } else if (this.loc) {
                return 'location/' + this.loc;
            }
        },
        searchName: function () {
            return (this.cat || this.loc) ? 'search' : 's';
        }
    },
    methods: {
        doSearch: function () {
            $("select[name='cat']").attr('disabled', true);
        },
    }
});