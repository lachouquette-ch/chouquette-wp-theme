<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="theme-color" content="#f8ef28"/>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<span id="colTrigger" class="d-none d-md-inline"></span>

<?php
if ( !is_home() ) :
    get_template_part( 'template-parts/menu' );
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
