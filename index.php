<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="theme-color" content="#f8ef28"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <?php wp_head(); ?>
<body>

<header class="index-header p-0 container-fluid h-100">
    <nav class="navbar navbar-chouquette">
        <button class="navbar-toggler d-inline d-md-none" type="button" data-toggle="collapse" data-target="#navbarChouquette" aria-controls="navbarChouquette" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="color: red;"></span>
        </button>
        <a class="navbar-brand d-none d-md-inline ml-md-5" href="/">
            <h1><?php bloginfo( 'name' ); ?></h1>
        </a>
        <div class="index-header-sn mr-md-5 my-2">
            <i class="fab fa-facebook-f"></i><i class="fab fa-instagram mx-4"></i><i class="fas fa-rss"></i>
        </div>

        <div class="collapse navbar-collapse" id="navbarChouquette">
            <?php
            // get menu items
            $menu_items = chouquette_menu_items();
            if ( ! empty ( $menu_items ) ) {
                echo '<ul class="navbar-nav mr-auto">';
                foreach ( $menu_items as $menu_item ) :
                    echo '<li class="nav-item">';
                    echo sprintf ( "<a class='nav-link' href='%s' title='%s'><i class='mr-2 %s'></i> %s</a>", $menu_item->url, $menu_item->description, $menu_item->logo_class, $menu_item->title );
                    echo '</li>';
                endforeach;
                echo '</ul>';
            } else {
                trigger_error( sprintf("Menu principal du thème '%s' non renseigné", CHOUQUETTE_PRIMARY_MENU), E_USER_WARNING );
            }
            ?>
        </div>
    </nav>

    <div class="d-flex flex-column h-100 p-3">
        <div class="flex-grow-1">
            <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                <div class="text-center d-block d-md-none mb-3">
                    <h1><?php bloginfo( 'name' ); ?></h1>
                </div>
                <?php
                // get menu items
                $menu_items = chouquette_menu_items();
                if ( ! empty ( $menu_items ) ) {
                    echo '<div class="d-none d-md-flex flex-row flex-wrap justify-content-center text-center">';
                    foreach ( $menu_items as $menu_item ) :
                        echo '<div class="index-header-category m-4">';
                        echo sprintf ( "<a href='%s' title='%s'>", $menu_item->url, $menu_item->description );
                        echo sprintf ( "<i class='index-header-category-icon %s'></i>", $menu_item->logo_class );
                        echo sprintf ( "<h2 class='my-2'>%s</h2>", $menu_item->title );
                        echo '</a>';
                        echo '</div>';
                    endforeach;
                    echo '</div>';
                } else {
                    trigger_error( sprintf("Menu principal du thème '%s' non renseigné", CHOUQUETTE_PRIMARY_MENU), E_USER_WARNING );
                }
                ?>
                <div class="index-header-filters text-center">
                    <form>
                        <div class="row">
                            <div class="col-md-4 index-header-filters-item">
                                <select class="form-control selectpicker show-tick" title="Où veux-tu aller ?" data-selected-text-format="count > 2" multiple data-actions-box="true">
                                    <option title="Vaud" value="0">Vaud</option>
                                    <option title="Lausanne" value="1"> • Lausanne</option>
                                    <option title="Morges" value="2"> • Morges</option>
                                    <option title="Genève" value="2">Genève</option>
                                    <option title="Valais" value="3">Valais</option>
                                </select>
                            </div>
                            <div class="col-md-4 index-header-filters-item">
                                <select class="form-control selectpicker show-tick" title="Qu'aimerais-tu faire ?">
                                    <?php
                                    // get menu items
                                    $menu_items = chouquette_menu_items();
                                    if ( ! empty ( $menu_items ) ) {
                                        foreach ( $menu_items as $menu_item ) :
                                            echo sprintf ( "<option data-icon='%s' value='%d'>%s</option>", $menu_item->logo_class, $menu_item->id, $menu_item->title );
                                        endforeach;
                                    } else {
                                    trigger_error( sprintf("Menu principal du thème '%s' non renseigné", CHOUQUETTE_PRIMARY_MENU), E_USER_WARNING );
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 index-header-filters-item">
                                <input class="form-control" type="text" placeholder="Un mot clef ?" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col index-header-filters-item">
                                <button class="btn btn-primary py-2 px-5" type="button">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="index-content">
    <div class="index-content-latest container my-3">
        <div class="row mb-xl-1">
            <div class="col text-center">
                <h2>Quoi de neuf ?</h2>
            </div>
        </div>
        <?php
        $latest_posts = new WP_Query('posts_per_page=5');
        if ($latest_posts->have_posts()) :
            if ($latest_posts->post_count == 5) :
                ?>
                <div class="row">
                <?php
                while ($latest_posts->have_posts()) :
                    $latest_posts->the_post();
                    // special 2nd article
                    $is_second_article = $latest_posts->current_post == 1;
                    $class_col = $is_second_article ? 'col-lg-8' : 'col-lg-4';
                    echo sprintf('<div class="index-content-latest-container %s">', $class_col);
                    get_template_part('template-parts/article-card');
                    echo '</div>';
                    if ($is_second_article)
                        echo '</div><div class="row">';
                endwhile;
                ?>
                </div>
            <?php
            else :
                error_log("Erreur. Il faut avoir au min 5 articles sur la blog");
            endif;
        endif;
        ?>
    </div>

    <div id="newsletter" class="container-fluid index-newsletter">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <h2 class="w-75 m-auto text-center">Pour être dans la confidence du meilleur de chez toi</h2>
            </div>
            <div class="col-lg-6">
                <p class="mb-1 h4">Rejoins notre newsletter</p>
                <p class="text-muted">Pour recevoir tous nos bons plans</p>
                <form class="form-inline mt-3">
                    <div class="form-row w-100">
                        <div class="col-lg-8 mb-2">
                            <input type="email" class="form-control form-control-lg w-100" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-secondary w-100 btn-lg">Je m'inscris</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid p-3 my-3">
        <div class="row mb-3">
            <div class="col text-center">
                <h2>Les tops !</h2>
            </div>
        </div>
        <div class="row swiper-container">
            <div class="swiper-wrapper">
                <?php
                $tops_posts = new WP_Query('posts_per_page=10');
                if ($tops_posts->have_posts()) :
                    while ($tops_posts->have_posts()) :
                        $tops_posts->the_post();
                        ?> <div class="swiper-slide bg-dark text-white"> <?php
                        get_template_part('template-parts/article-card');
                        ?> </div> <?php
                    endwhile;
                endif;
                ?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-black"></div>
            <div class="swiper-button-prev swiper-button-black"></div>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-4 p-0" style="background-image: url('http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-1.jpg')">
                <img class="w-100" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-1a.png">
            </div>
            <div class="col-md-4 p-0" style="background-image: url('http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-2.jpg')">
                <img class="w-100" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-2a.png">
            </div>
            <div class="col-md-4 p-0" style="background-image: url('http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-3.jpg')">
                <img class="w-100" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-single-img-banner-3a.png">
            </div>
        </div>
    </div>
</div>

<footer class="index-footer container-fluid text-center">
    <div class="index-footer-top row pt-3">
        <div class="col">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            if ( has_custom_logo() ) {
                echo sprintf('<img style="height: 15rem" class="mx-auto" src="%s">', esc_url( $logo[0] ));
            }
            ?>
            <p class="my-3">
                <a href="#" class="px-2 d-inline-block">Qui sommes-nous ?</a><a href="#" class="px-2  d-inline-block">Charte éditoriale</a><a href="#" class="px-2 d-inline-block">Contact</a><a href="#newsletter" class="px-2 d-inline-block">Newsletter</a>
            </p>
        </div>
    </div>
    </div>
    <div class="index-footer-bottom row py-3">
        <div class="col">
            <span>Copyright 2014-2019 - Tous droits réservés à La Chouquette. Toutes les images et le contenu sont la propriété du site.</span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>