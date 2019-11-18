import Vue from 'vue';

import VUE_UTILITY_MIXIN from "./vue/utility-mixin";
import VUE_FICHE_MIXIN from "./vue/fiche-mixin";

const app = new Vue({
    el: '#app',
    mixins: [VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN]
});