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
</head>
<body <?php body_class(); ?>>
<span id="colTrigger" class="d-none d-md-inline"></span>

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
