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
            <h1>La Chouquette</h1>
        </a>
        <div class="index-header-sn mr-md-5 my-2">
            <i class="fab fa-facebook-f"></i><i class="fab fa-instagram mx-4"></i><i class="fas fa-rss"></i>
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
                <div class="text-center d-block d-md-none mb-3">
                    <h1>La Chouquette</h1>
                </div>
                <div class="d-none d-md-flex flex-row flex-wrap justify-content-center text-center">
                    <div class="index-header-category m-4">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-4">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-4">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-4">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                    <div class="index-header-category m-4">
                        <img src="http://findme.elated-themes.com/wp-content/uploads/2017/06/type-img-1.png" alt="Type Icon">
                        <h2 class="my-2">Food & Drink</h2>
                    </div>
                </div>
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
                                    <option data-icon="fas fa-cocktail" value="1">Boire et manger</option>
                                    <option data-icon="fas fa-theater-masks" value="2">Culture</option>
                                    <option data-icon="fa fa-user-circle" value="3">Interviews</option>
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
                    if ($latest_posts->current_post == 1) :
                        set_query_var('col_size', '8');
                        get_template_part('template-parts/index/latest_col');
                        ?>
                        </div>
                        <div class="row">
                    <?php
                    else :
                        set_query_var('col_size', '4');
                        get_template_part('template-parts/index/latest_col');
                    endif;
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

    <div class="container-fluid index-newsletter">
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
</div>

<footer class="index-footer container-fluid text-center">
    <div class="index-footer-top row py-3">
        <div class="col">
            <img style="height: 15rem" class="mx-auto" src="//projet-chouquette.site/wp-content/uploads/2017/06/Logo-Lausanne-More.jpg">
            <div class="index-footer-sn my-3"><i class="fab fa-facebook-f"></i><i class="fab fa-instagram mx-4"></i><i class="fas fa-rss"></i></div>
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