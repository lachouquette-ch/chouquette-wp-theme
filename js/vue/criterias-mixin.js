var VUE_CRITERIAS_MIXIN = {
    data: function () {
        return {
            criterias: [],
        }
    },
    computed: {
        criteriaCount: function() {
            var count = 0;
            this.criterias.forEach(function(criteria) {
                count += criteria.selectedTerms.length;
            })
            return count;
        },
        criteriaLabel: function() {
            if (this.criteriaCount > 1) {
                return this.criteriaCount + " critères sélectionnés";
            } else if (this.criteriaCount == 1) {
                return "1 critère sélectionné";
            } else {
                return "Plus de critères";
            }
        }
    },
    methods: {
        // get criterias from remote based on given category
        refreshCriterias: function (category) {
            var self = this;
            axios.get('/wp-json/cq/v1/category/taxonomy?cat=' + category)
                .then(function (response) {
                    response.data.forEach(function (taxonomy) {
                        taxonomy.selectedTerms = [];
                        taxonomy.terms.forEach(function (term) {
                            if (self.$_params.getAll(taxonomy.name).includes(term.slug)) {
                                taxonomy.selectedTerms.push(term.slug);
                            }
                        });
                    });
                    self.criterias = response.data;
                });
        },
        // uncheck add criterias
        resetCriterias: function () {
            this.criterias.forEach(function (taxonomy) {
                taxonomy.selectedTerms = [];
            })
        }
    }
}