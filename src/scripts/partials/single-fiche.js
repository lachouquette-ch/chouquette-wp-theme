// nothing to do
function bootstrapMap() {
    app.showFicheMap();
};

var app = new Vue({
    el: '#app',
    mixins: [VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    methods: {
        showFicheMap: function() {
            var ficheElement = $("article.fiche");
            this.bootstrapFicheMap(ficheElement);
        }
    }
});
