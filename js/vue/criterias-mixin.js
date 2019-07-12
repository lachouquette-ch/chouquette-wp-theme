var VUE_CRITERIAS_MIXIN = {
    data: function () {
        return {
            criterias: null,
            hasCriterias: false,
        }
    },
    computed: {
        // helper to create proper grid columns
        criteriaRows: function () {
            if (!this.criterias) {
                return [];
            }

            var result = [];
            for (var i = 0; i < this.criterias.length; i = i + 2) {
                result.push(this.criterias.slice(i, i + 2));
            }
            return result;
        },
    },
    methods: {
        // get criterias from remote based on given category
        refreshCriterias: function (category) {
            axios
                .get(`http://chouquette.test/wp-json/cq/v1/category/taxonomy?cat=${category}`)
                .then(function (response) {
                    response.data.forEach(function (taxonomy) {
                        taxonomy.terms.forEach(function (term) {
                            if (app.$_params.getAll(taxonomy.name).includes(term.slug)) {
                                term.checked = true;
                                app.hasCriterias = true;
                            }
                        });
                    });
                    app.criterias = response.data;
                });
        },
        // uncheck add criterias
        resetCriterias: function () {
            this.criterias.forEach(function (taxonomy) {
                taxonomy.terms.forEach(function (term) {
                    term.checked = false;
                })
            })
        }
    }
}