import Vue from 'vue';

import VUE_CRITERIA_MIXIN from "./vue/criteria-mixin";
import VUE_UTILITY_MIXIN from "./vue/utility-mixin";
import VUE_FICHE_MIXIN from "./vue/fiche-mixin";

var app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIA_MIXIN, VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    mounted: function () {
        this.refreshCriterias('services');
    }
});