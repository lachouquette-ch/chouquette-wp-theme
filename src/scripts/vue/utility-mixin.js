const VUE_UTILITY_MIXIN = {
    data: {
        $_params: null
    },
    methods: {
        // hack to know if on mobile or not
        _colEnabled() {
            return window.getComputedStyle(document.getElementById('colTrigger')).display != "none";
        }
    },
    created() {
        // create instance of URLSearch
        this.$_params = new URLSearchParams(window.location.search);
        for (const [key, value] of this.$_params.entries()) {
            if (value.includes(',')) {
                value.split(',').map(term => {
                    this.$_params.append(key, term)
                });
            }
        }
    }
};

export default VUE_UTILITY_MIXIN;