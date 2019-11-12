import axios from 'axios';

const VUE_CRITERIAS_MIXIN = {
    data() {
        return {
            criterias: [],
        }
    },
    computed: {
        // for select only (mobile)
        criteriaCount() {
            let count = 0;
            for (const criteria of this.criterias) {
                count += criteria.selectedTerms.length;
            }
            return count;
        },
        // for checkbox only (desktop)
        checkedCount() {
            let count = 0;
            for (const criteria of this.criterias) {
                let checkedTerms = criteria.terms.filter(term => term.checked);
                count += checkedTerms.length;
            }
            return count;
        }
    },
    methods: {
        // get text for critiera button
        criteriaLabel(selectedCriterias) {
            if (selectedCriterias > 1) {
                return selectedCriterias + " critères sélectionnés";
            } else if (selectedCriterias == 1) {
                return "1 critère sélectionné";
            } else {
                return "Plus de critères";
            }
        },
        // get criterias from remote based on given category
        refreshCriterias(category) {
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
        },
        // uncheck add criterias
        resetCriterias() {
            for (const taxonomy of this.criterias) {
                taxonomy.selectedTerms = [];
                for (let term of taxonomy.terms) {
                    term.checked = false;
                }
            }
        },
        // properly remove uncheck term
        toggleCheckCritera(term) {
            if (!term.checked) {
                for (const taxonomy of this.criterias) {
                    taxonomy.selectedTerms = taxonomy.selectedTerms.filter(element => element != term.slug);
                }
                ;
            }
        }
    }
}

export default VUE_CRITERIAS_MIXIN;