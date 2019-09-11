// repaptcha for contact
grecaptcha.ready(function () {
    grecaptcha.execute(CQ_RECAPTCHA_SITE, {action: 'article'}).then(function (token) {
        var elements = document.getElementsByName("recaptcha-response");
        for (i = 0; i < elements.length; i++) {
            elements[i].value = token;
        }
    });
});

// nothing to do
function bootstrapMap() {};

var app = new Vue({
    el: '#app',
    mixins: [VUE_UTILITY_MIXIN, VUE_FICHE_MIXIN],
    data: function () {
        return {
            firstShow: true,
        }
    },
    methods: {
        toggleFiches: function () {
            $(".cq-single-post-fiches").toggleClass("open");
            $(".cq-single-post-fiches > button").attr('aria-expanded', function (i, attr) {
                return attr == 'true' ? 'false' : 'true'
            });

            if (this.firstShow) {
                $("#fichesAccordion > div:last-of-type").collapse("show");
                this.firstShow = false;
            }
        }
    },
    mounted: function () {
        $(".cq-single-post-fiches-btn-sm").delay(1000).queue(function (next) {
            $(this).css('right', '-150px');
            next();
        });

        // handle accordion. needs to be launched afterwork so fiche heights can be computed properly
        $("#fichesAccordion").collapse();
        $("#fichesAccordion > div").collapse("hide");
    }
});
