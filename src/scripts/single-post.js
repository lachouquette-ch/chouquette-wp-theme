import Vue from 'vue';
import $ from 'jquery';

import VUE_UTILITY_MIXIN from "./vue/utility-mixin";
import VUE_FICHE_MIXIN from "./vue/fiche-mixin";
import buildAndStartSwiper from "./misc/swiper";

$(function () {
    const swiper = buildAndStartSwiper();
});

const app = new Vue({
    el: '#app',
    mixins: [VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    data: {
        firstShow: true,
    },
    methods: {
        toggleFiches() {
            $(".cq-single-post-fiches").toggleClass("open");
            $(".cq-single-post-fiches > button").attr('aria-expanded', function (i, attr) {
                return attr == 'true' ? 'false' : 'true'
            });

            if (this.firstShow) {
                $("#fichesAccordion > div:last-of-type").collapse("show");
                this.firstShow = false;
            }
        }
    },
    mounted() {
        $(".cq-single-post-fiches-btn-sm").delay(1000).queue(function (next) {
            $(this).css('right', '-150px');
            next();
        });

        // handle accordion. needs to be launched afterwork so fiche heights can be computed properly
        $("#fichesAccordion").collapse();
        $("#fichesAccordion > div").collapse("hide");
    }
});