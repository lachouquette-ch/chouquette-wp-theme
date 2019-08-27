// repaptcha for contact
grecaptcha.ready(function () {
    grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'article'}).then(function (token) {
        var elements = document.getElementsByName("recaptcha-response");
        for (i = 0; i < elements.length; i++) {
            elements[i].value = token;
        }
    });
});

var app = new Vue({
    el: '#app',
    mixins: [VUE_UTILITY_MIXIN],
    data: function () {
        return {
            unfold: true
        }
    },
    methods: {
        showFiches: function () {
            $(".cq-single-post-fiches").toggle(200, function() {
                app.unfold = !app.unfold;
            });
        }
    },
    mounted: function () {
        $(".cq-single-post-fiches").hide();
    }
});
