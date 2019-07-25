<?php get_header(); ?>

    <header class="home-header p-0 container-fluid h-100">
        <nav class="navbar navbar-chouquette">
            <button class="navbar-toggler d-inline d-md-none" type="button" data-toggle="collapse" data-target="#navbarChouquette" aria-controls="navbarChouquette" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-none d-md-inline ml-md-5" href="/">
                <h1><?php bloginfo('name'); ?></h1>
            </a>
            <div class="home-header-sn mr-md-5 my-2">
                <a href="<?php echo esc_url(CQ_SN_FACEBOOK); ?>" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="<?php echo esc_url(CQ_SN_INSTAGRAM); ?>" title="Instagram"><i class="fab fa-instagram ml-4"></i></a>
                <a href="#newsletter" title="Newsletter"><i class="far fa-envelope ml-4"></i></a>
                <a href="<?php bloginfo('atom_url'); ?>" title="RSS"><i class="fas fa-rss ml-4"></i></a>
            </div>

            <div class="collapse navbar-collapse" id="navbarChouquette">
                <?php chouquette_navbar_nav('yellow'); ?>
            </div>
        </nav>

        <div class="home-header-menu d-flex flex-column h-100 p-3">
            <div class="flex-grow-1">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    <div class="text-center">
                        <h1 class="d-block d-md-none mb-5"><?php bloginfo('name'); ?></h1>
                        <h3 class="mb-3"><?php bloginfo('description'); ?></h3>
                    </div>
                    <?php
                    // get menu items
                    $menu_items = chouquette_menu_items();
                    if (!empty ($menu_items)) {
                        echo '<div class="d-none d-md-flex flex-row flex-wrap justify-content-center text-center">';
                        foreach ($menu_items as $menu_item) :
                            echo '<div class="home-header-category m-4">';
                            echo sprintf("<a href='%s' title='%s'>", esc_url($menu_item->url), $menu_item->description);
                            echo '<div class="home-header-category-logo p-3">';
                            echo chouquette_taxonomy_logo($menu_item);
                            echo '</div>';
                            echo "<h2 class='my-2'>{$menu_item->title}</h2>";
                            echo '</a>';
                            echo '</div>';
                        endforeach;
                        echo '</div>';
                    } else {
                        trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
                    }
                    ?>
                    <div class="home-header-filters text-center">
                        <form :action="action" v-on:submit.capture="doSearch" id="app">
                            <div class="row">
                                <div class="col-md-4 home-header-filters-item">
                                    <select class="form-control" title="Où veux-tu aller ?" name="loc" v-model="loc">
                                        <option title="" value="">Où veux-tu aller ?</option>
                                        <?php
                                        $terms = get_terms(array(
                                            'taxonomy' => CQ_TAXONOMY_LOCATION,
                                            'hide_empty' => false,
                                            'orderby' => 'term_group'
                                        ));
                                        foreach ($terms as $term) {
                                            $term_style = $term->parent == 0 ? 'font-weight: bold' : '';
                                            $term_display = $term->parent != 0 ? '&nbsp;&nbsp;' : '';
                                            $term_display .= $term->name;
                                            echo "<option title='{$term->name}' value='{$term->slug}' style='${term_style}'>{$term_display}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 home-header-filters-item">
                                    <select class="form-control" title="Qu'aimerais-tu faire ?" name="cat" v-model="cat">
                                        <option title="" value="">Qu'aimerais-tu faire ?</option>
                                        <?php
                                        // get menu items
                                        $menu_items = chouquette_menu_items();
                                        if (!empty ($menu_items)) {
                                            foreach ($menu_items as $menu_item) :
                                                $category = get_category($menu_item->object_id);
                                                echo "<option title='{$menu_item->title}' value='{$category->slug}'>{$category->name}</option>";
                                            endforeach;
                                        } else {
                                            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 home-header-filters-item">
                                    <input class="form-control" type="text" placeholder="Un mot clef ?" :name="searchName" v-model="search">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col home-header-filters-item">
                                    <button class="btn btn-primary py-2 px-5" type="submit">Rechercher</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="home-header-menu-next align-self-center d-flex align-items-center justify-content-center">
                <a href="#homeContent" class="text-center">
                    <i class="fas fa-chevron-down"></i><br/>
                    <span>La suite</span>
                </a>
            </div>
        </div>
    </header>

    <div id="homeContent" class="home-content">
        <div class="home-content-latest container">
            <div class="row mb-xl-1">
                <div class="col text-center">
                    <h2 class="my-4">Nos derniers articles</h2>
                </div>
            </div>
            <?php
            $latest_posts = new WP_Query('posts_per_page=6');
            if ($latest_posts->have_posts()) :
                ?>
                <div class="row shadow-lg">
                    <?php
                    while ($latest_posts->have_posts()) :
                        $latest_posts->the_post();
                        echo '<div class="home-content-latest-container col-lg-4">';
                        get_template_part('template-parts/article-card');
                        echo '</div>';
                    endwhile;
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div id="newsletter" class="container-fluid home-newsletter px-4 py-4 my-5">
            <div class="row">
                <div class="col-lg-6 m-md-auto mb-3">
                    <h2 class="w-75 m-auto text-center">Pour être dans la confidence du meilleur de chez toi</h2>
                </div>
                <div class="col-lg-6">
                    <p class="mb-1 h4">Rejoins notre newsletter</p>
                    <p class="text-muted">Pour recevoir tous nos bons plans et ne plus rien rater</p>
                    <div id="mc_embed_signup">
                        <form class="validate form-inline mt-3" action="https://unechouquettealausanne.us8.list-manage.com/subscribe/post?u=570ea90f4cbc136c450fe880a&amp;id=26f7afd6a2" method="post"
                              id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                            <div class="form-row w-100">
                                <div class="col-lg-8 mb-2">
                                    <input type="email" value="" name="EMAIL" class="required email form-control form-control-lg w-100" id="mce-EMAIL" aria-describedby="emailHelp"
                                           placeholder="Ton email">
                                    <div id="mce-responses" class="home-newsletter-response">
                                        <div class="index-newsletter-response-error mt-2" id="mce-error-response" style="display:none"></div>
                                        <div class="index-newsletter-response-success mt-2" id="mce-success-response" style="display:none"></div>
                                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_570ea90f4cbc136c450fe880a_26f7afd6a2" tabindex="-1" value=""></div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-white w-100 btn-lg">Je m'inscris</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-4">
            <div class="row mb-3">
                <div class="col text-center">
                    <h2>Nos tops !</h2>
                </div>
            </div>
            <div class="row swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $tops_posts = new WP_Query('posts_per_page=10&tag=tops&orderby=rand');
                    if ($tops_posts->have_posts()) :
                        while ($tops_posts->have_posts()) :
                            $tops_posts->the_post();
                            ?>
                            <div class="swiper-slide bg-dark text-white shadow-sm"> <?php
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

    </div>
<?php

wp_enqueue_script('index', get_template_directory_uri() . '/home.js', ['vue'], CQ_THEME_VERSION, true);

get_footer();