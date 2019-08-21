const VUE_CRITERIAS_MIXIN = {
    data: function () {
        return {
            criterias: [],
        }
    },
    computed: {
        // for select only (mobile)
        criteriaCount: function () {
            var count = 0;
            this.criterias.forEach(function (criteria) {
                count += criteria.selectedTerms.length;
            })
            return count;
        },
        // for checkbox only (desktop)
        checkedCount: function () {
            var count = 0;
            this.criterias.forEach(function (criteria) {
                var checkedTerms = criteria.terms.filter(function (term) {
                    return term.checked;
                });
                count += checkedTerms.length;
            })
            return count;
        }
    },
    methods: {
        // get text for critiera button
        criteriaLabel: function (selectedCriterias) {
            if (selectedCriterias > 1) {
                return selectedCriterias + " critères sélectionnés";
            } else if (selectedCriterias == 1) {
                return "1 critère sélectionné";
            } else {
                return "Plus de critères";
            }
        },
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
                                term.checked = true;
                            }
                        });
                    });
                    self.criterias = response.data;
                })
                .then(function () {
                    // activate new tooltips
                    // next cycle (for IE)
                    Vue.nextTick(function () {
                        $('.category-criteria i[data-toggle="tooltip"]').tooltip();
                    });
                })
        },
        // uncheck add criterias
        resetCriterias: function () {
            this.criterias.forEach(function (taxonomy) {
                taxonomy.selectedTerms = [];
                taxonomy.terms.forEach(function (term) {
                    term.checked = false;
                });
            })
        }
    }
}