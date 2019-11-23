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
        var queryParams = location.search.replace(/%5B%5D/g, ''); // remove []
        this.$_params = new URLSearchParams(queryParams);
    }
};

export default VUE_UTILITY_MIXIN;