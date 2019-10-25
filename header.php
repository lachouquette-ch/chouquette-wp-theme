<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Type" content="text/html"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="profile" href="https://gmpg.org/xfn/11"/>
    <link rel="alternate" type="application/atom+xml" href="<?php bloginfo('atom_url'); ?>"/>
    <meta name="theme-color" content="#f8ef28"/>

    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-47894326-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->

    <?php wp_head(); ?>

    <?php
    // compute canonical links
    global $wp;
    $canonical_url = home_url($wp->request);

    if (is_category() || is_tax(CQ_TAXONOMY_LOCATION)) {
        echo "<link rel='canonical' href='$canonical_url'/>";
    }
    if (is_search()) {
        $canonical_url = add_query_arg('s', $wp->query_vars['s'], home_url('/'));
        echo "<link rel='canonical' href='$canonical_url'/>";
    }
    // need to add og:url since yoast canonical is disabled (cf. template-pagination.php)
    echo "<meta property='og:url' content='$canonical_url'/>";
    ?>
</head>
<body <?php body_class(); ?>>
<span id="colTrigger" class="d-none d-md-inline"></span>

<!-- Newsletter Modal -->
<div class="modal fade cq-modal" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="newsletterModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsletterModalTitle">Rejoins notre newsletter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="validate" action="https://unechouquettealausanne.us8.list-manage.com/subscribe/post?u=570ea90f4cbc136c450fe880a&amp;id=26f7afd6a2" method="post"
                      id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                    <div class="input-group">
                        <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" aria-describedby="emailHelp" placeholder="Enter email" autofocus>
                        <div class="input-group-append">
                            <button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">Je m'inscris</button>
                        </div>
                    </div>
                    <div id="mce-responses" class="home-newsletter-response">
                        <div class="index-newsletter-response-error mt-2" id="mce-error-response" style="display:none"></div>
                        <div class="index-newsletter-response-success mt-2" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_570ea90f4cbc136c450fe880a_26f7afd6a2" tabindex="-1" value=""></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (!is_home()) :
    get_template_part('template-parts/menu');
endif;

/* Print messages (mostly from posting redirects) */
if (isset($_COOKIE[CQ_COOKIE_PREFIX . 'message_status']) && isset($_COOKIE[CQ_COOKIE_PREFIX . 'message_content'])) {
    switch ($_COOKIE[CQ_COOKIE_PREFIX . 'message_status']) {
        case 'success':
            $alert = 'success';
            break;
        case 'failure':
            $alert = 'danger';
            break;
        default:
            $alert = 'light';
    }
    chouquette_header_alert($alert, base64_decode($_COOKIE[CQ_COOKIE_PREFIX . 'message_content']));
    // unset cookies
    unset($_COOKIE[CQ_COOKIE_PREFIX . 'message_status']);
    unset($_COOKIE[CQ_COOKIE_PREFIX . 'message_content']);
}
