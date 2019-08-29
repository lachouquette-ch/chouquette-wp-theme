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
    mixins: [VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    methods: {
        showFiches: function () {
            $(".cq-single-post-fiches").toggleClass("open");
            $(".cq-single-post-fiches > button").attr('aria-expanded', function (i, attr) {
                return attr == 'true' ? 'false' : 'true'
            });
        }
    },
    mounted: function () {
        $(".cq-single-post-fiches-btn-sm").delay(500).queue(function (next) {
            $(this).css('right', '-110px');
            next();
        });
    }
});
