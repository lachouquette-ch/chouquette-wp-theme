var app = new Vue({
    el: '#app',
    data() {
        return {
            loc: '',
            cat: '',
            search: ''
        }
    },
    computed: {
        // helper to create proper grid columns
        action: function () {
            if (this.cat) {
                return `category/${this.cat}`;
            } else if (this.loc) {
                return `location/${this.loc}`;
            }
        },
        searchName: function () {
            return (this.cat || this.loc) ? 'search' : 's';
        }
    },
});