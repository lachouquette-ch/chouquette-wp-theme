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
<body>

<?php
if ( !is_home() ) :
    get_template_part( 'template-parts/menu' );
endif;

// print alerts (callback from posting)
if (!empty($_GET)) {
    if (isset($_GET['success'])) {
        chouquette_header_alert('success', base64_decode($_GET['success']));
    }
    if (isset($_GET['failure'])) {
        chouquette_header_alert('danger', base64_decode($_GET['failure']));
    }
}
