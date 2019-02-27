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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="color: red;"></span>
        </button>
        <div class="index-header-sn">
            <i class="fab fa-pinterest-square mr-2"></i><i class="fab fa-facebook mx-2"></i><i class="fab fa-instagram mx-2"></i><i class="fas fa-rss-square ml-2"></i>
        </div>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu 5</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex flex-column h-100 p-3">
        <div class="flex-grow-1">
            <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                <div class="text-center mb-3">
                    <h1>La Chouquette</h1>
                </div>
                <div class="d-none d-md-flex flex-row flex-wrap justify-content-center text-center">
                    <div class="index-header-category m-3">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-3">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-3">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-3">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-3">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                </div>
                <form class="index-header-filters row w-75">
                    <div class="col-lg-3 index-header-filters-item">
                        <select class="w-100 form-control selectpicker show-tick" title="Choisi ton lieu" data-selected-text-format="count > 2" multiple data-actions-box="true">
                            <option title="Vaud" value="0">Vaud</option>
                            <option title="Lausanne" value="1"> • Lausanne</option>
                            <option title="Morges" value="2"> • Morges</option>
                            <option title="Genève" value="2">Genève</option>
                            <option title="Valais" value="3">Valais</option>
                        </select>
                    </div>
                    <div class="col-lg-3 index-header-filters-item">
                        <select class="w-100 form-control selectpicker show-tick" title="et la catégorie">
                            <option data-icon="fas fa-cocktail" value="1">Boire et manger</option>
                            <option data-icon="fas fa-theater-masks" value="2">Culture</option>
                            <option data-icon="fa fa-user-circle" value="3">Interviews</option>
                        </select>
                    </div>
                    <div class="col-lg-3 index-header-filters-item">
                        <input class="w-100 form-control" type="text" placeholder="mots clefs" aria-label="" aria-describedby="basic-addon1">
                    </div>
                    <div class="col-lg-3 index-header-filters-item">
                        <button class="w-100 btn btn-outline-primary" type="button">Cherche moi des lieux</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="container my-3 my-xl-5">
    <div class="row mb-xl-1">
        <div class="col text-center">
            <h3>Les derniers articles</h3>
        </div>
    </div>
    <?php
    $latest_posts = new WP_Query('posts_per_page=5');
    if ( $latest_posts->have_posts()) :
        if ( $latest_posts->post_count == 5) :
            ?>
            <div class="row">
            <?php
            while ( $latest_posts->have_posts() ) :
                $latest_posts ->the_post();
                // special 2nd article
                if ($latest_posts->current_post == 1) :
                    set_query_var( 'col_size', '8' );
                    get_template_part( 'template-parts/home/latest_col' );
                    ?>
                    </div>
                    <div class="row">
                    <?php
                else :
                    set_query_var( 'col_size', '4' );
                    get_template_part( 'template-parts/home/latest_col' );
                endif;
            endwhile;
            ?>
            </div>
            <?php
        else :
            error_log( "Erreur. Il faut avoir au min 5 articles sur la blog" );
        endif;
    endif;
    ?>
</div>

<div class="container-fluid index-newsletter">
    <div class="row">
        <div class="col-lg-6">
            Inscrit toi à la newsletter pour te tenir au courant des dernières nouveautés
        </div>
        <div class="col-lg-6">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ton adresse mail</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">Nous ne partageons pas ton adresse email avec quiconque.</small>
                </div>
                <button type="submit" class="btn btn-secondary">Je m'inscris</button>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid p-3 my-3 my-xl-5">
    <div class="row mb-3">
        <div class="col text-center">
            <h3>Les tops !</h3>
        </div>
    </div>
    <div class="row swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide card bg-dark text-white">
                <img class="card-img" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-listing-img-1.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
            <div class="swiper-slide card bg-dark text-white">
                <img class="card-img" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-listing-img-1.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
            <div class="swiper-slide card bg-dark text-white">
                <img class="card-img" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-listing-img-1.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
            <div class="swiper-slide card bg-dark text-white">
                <img class="card-img" src="http://findme.elated-themes.com/wp-content/uploads/2017/06/h2-listing-img-1.jpg" alt="Card image">
                <div class="card-img-overlay">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-black"></div>
        <div class="swiper-button-prev swiper-button-black"></div>
    </div>
</div>

<footer class="index-footer container-fluid text-center">
    <div class="index-footer-top row py-3">
        <div class="col">
            <img style="height: 15rem" class="mx-auto" src="//projet-chouquette.site/wp-content/uploads/2017/06/Logo-Lausanne-More.jpg">
            <div class="index-footer-sn my-3"><i class="fab fa-pinterest-square mr-2"></i><i class="fab fa-facebook mx-2"></i><i class="fab fa-instagram mx-2"></i><i class="fas fa-rss-square ml-2"></i></div>
            <p class="mypacka-2"><span class="px-2">L'équipe</span><span class="px-2">Charte éditorial</span><span class="px-2">Contact</span></div>
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