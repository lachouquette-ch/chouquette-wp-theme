var app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIAS_MIXIN, VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    mounted: function () {
        this.refreshCriterias('services');
    }
});