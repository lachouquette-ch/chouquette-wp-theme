var app = new Vue({
    el: '#app',
    mixins: [VUE_CRITERIAS_MIXIN, VUE_UTILITY_MIXIN],
    mounted() {
        this.refreshCriterias('les-services');
    }
});