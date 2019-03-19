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

<header class="cq-header">
    <nav class="navbar fixed-top navbar-chouquette-light navbar-expand-md">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarChouquette" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand ml-3 mr-md-5" href="/"><?php bloginfo('name'); ?></a>

        <div class="collapse navbar-collapse" id="navbarChouquette">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#" title="Bars et Restos"><i class="fas fa-cocktail mr-2"></i><span class="nav-link-text">Bars et Restos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Culture"><i class="fas fa-theater-masks mr-2"></i><span class="nav-link-text">Culture</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Loisirs"><i class="fab fa-angellist mr-2"></i><span class="nav-link-text">Loisirs</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Shopping"><i class="fas fa-shopping-bag mr-2"></i><span class="nav-link-text">Shopping</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Les Chouchous"><i class="fas fa-grin-hearts mr-2"></i><span class="nav-link-text">Les Chouchous</span></a>
                </li>
            </ul>
            <div class="navbar-divider"></div>
            <div class="navbar-sn mr-3">
                <a href="<?php echo esc_url(CHOUQUETTE_SN_FACEBOOK); ?>" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="<?php echo esc_url(CHOUQUETTE_SN_INSTAGRAM); ?>" title="Instagram"><i class="fab fa-instagram ml-3"></i></a>
                <a href="#" title="Newsletter" data-toggle="modal" data-target="#newsletterModal"><i class="far fa-envelope ml-3"></i></a>
                <a href="<?php bloginfo('atom_url'); ?>" title="RSS"><i class="fas fa-rss ml-3"></i></a>
                <a href="#" title="Recherche" class="d-none d-md-inline-block" data-toggle="modal" data-target="#searchModal"><i class="fas fa-search ml-3"></i></a>
            </div>
            <form class="d-md-none">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="search" placeholder="Recherche" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
    <div id="gotoFiche" class="w-100 text-center d-lg-none">
        <a href="#ficheTarget" class="py-1 px-3"><small><i class="fas fa-info mr-1"></i> Fiche</small></a>
    </div>
</header>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Mots clefs ?" aria-label="Mots clefs ?">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="newsletterModalTitle" aria-hidden="true">
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
                        <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" aria-describedby="emailHelp"
                               placeholder="Enter email">
                        <div class="input-group-append">
                            <button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">Je m'inscris</button>
                        </div>
                    </div>
                    <div id="mce-responses" class="index-newsletter-response">
                        <div class="index-newsletter-response-error mt-2" id="mce-error-response" style="display:none"></div>
                        <div class="index-newsletter-response-success mt-2" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_570ea90f4cbc136c450fe880a_26f7afd6a2" tabindex="-1" value=""></div>
                </form>
            </div>
        </div>
    </div>
</div>

<article class="container cq-single">
    <div class="row cq-single-header mt-0 mt-lg-4">
        <div class="col p-0">
            <img class="cq-single-header-img" src="http://lachouquette.ch/wp-content/uploads/2019/03/Salle-vide-1140x759.jpg" alt="blalbabla">
            <img class="cq-single-header-author-img rounded-circle" src="http://0.gravatar.com/avatar/ff03948ae1055f3da0cf6b223729cf54?s=140&amp;d=blank&amp;r=g" alt="Justine" width="140"
                 height="140">
            <div class="cq-single-header-meta">
                <span>par Justine</span>
                <span>le 6 mars 2019</span>
                <span>dans <a name="desc" href="#" class="sing-header-link">Sorties</a> / <a name="desc" href="#">Culture</a></span>
            </div>
        </div>
    </div>

    <div class="row cq-single-content">
        <div class="col-lg-8 px-lg-0">
            <div class="cq-single-content-title mt-3 mb-2">
                <h1 class="mb-0 mr-2">Le titre</h1>
            </div>
            <main class="cq-single-content-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pellentesque sit amet purus vitae sodales. Nulla vitae libero eget nibh venenatis convallis accumsan non nisl.
                Suspendisse est magna, commodo et bibendum id, egestas non dui. Nam mauris leo, commodo ut facilisis quis, congue non justo. Vestibulum tempus dapibus massa sed pulvinar. Sed finibus
                consectetur ante quis blandit. Aenean a vehicula eros, mollis faucibus augue. Fusce venenatis pellentesque nisi.

                Vivamus lacus leo, mollis eget malesuada et, tempus at eros. Nam hendrerit non augue non tristique. Donec dui risus, feugiat nec hendrerit efficitur, blandit a nisi. Vivamus pretium
                ultrices neque a bibendum. Ut lectus neque, lacinia sit amet imperdiet in, condimentum sit amet purus. Ut ornare erat at dolor rhoncus dignissim. Nunc blandit ligula ut dolor posuere,
                ac tempor quam venenatis.

                Duis fringilla consequat elit eu tristique. Maecenas magna sapien, efficitur vel fermentum at, aliquam et metus. Pellentesque nec magna ac eros tristique aliquam eget et erat. Ut ac
                est nibh. Donec condimentum facilisis porttitor. Sed rhoncus viverra est sed fringilla. Pellentesque vel interdum eros. Etiam hendrerit nisi ultricies, facilisis metus ut, aliquet
                ipsum. Integer quis mauris rutrum magna luctus laoreet vitae eu mauris. Suspendisse potenti.

                Phasellus sollicitudin pulvinar fermentum. Aenean eu nisi tincidunt massa maximus sagittis. Maecenas quis odio pulvinar, vulputate purus laoreet, aliquam metus. Proin quis elit
                commodo, suscipit tellus id, tempus nisl. Nunc arcu erat, gravida quis elementum sit amet, placerat id erat. Proin sit amet lectus turpis. Aliquam tempus eget sem a pellentesque. Sed
                velit sem, viverra quis interdum ut, sodales convallis ex. Cras eu dapibus urna, ac ultrices nulla. Aliquam et neque sem. Fusce iaculis massa a ante cursus, a facilisis augue
                ullamcorper. Fusce aliquet, lorem eget fringilla pretium, eros lectus feugiat sapien, in varius libero magna ut elit. Nam quis ultricies magna. Aenean molestie mi eu sodales luctus.

                Fusce malesuada turpis eget justo tristique, quis suscipit mauris malesuada. Morbi fringilla nulla lacus, eu volutpat justo faucibus et. Cras et mauris non arcu tempor aliquam sit amet
                quis augue. Fusce interdum nulla quis porta sagittis. Aliquam finibus justo non congue porttitor. Praesent scelerisque rutrum tortor a scelerisque. Curabitur fringilla fermentum nisi
                sit amet condimentum. Curabitur mattis dignissim arcu, ac dictum metus mollis sit amet. Nullam tincidunt vitae diam vel blandit. Mauris in sapien vel mi pretium malesuada. Pellentesque
                non volutpat justo, in dapibus lectus. Pellentesque mi lectus, gravida ut leo nec, tempor tincidunt libero.

                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pellentesque sit amet purus vitae sodales. Nulla vitae libero eget nibh venenatis convallis accumsan non nisl.
                Suspendisse est magna, commodo et bibendum id, egestas non dui. Nam mauris leo, commodo ut facilisis quis, congue non justo. Vestibulum tempus dapibus massa sed pulvinar. Sed finibus
                consectetur ante quis blandit. Aenean a vehicula eros, mollis faucibus augue. Fusce venenatis pellentesque nisi.

                Vivamus lacus leo, mollis eget malesuada et, tempus at eros. Nam hendrerit non augue non tristique. Donec dui risus, feugiat nec hendrerit efficitur, blandit a nisi. Vivamus pretium
                ultrices neque a bibendum. Ut lectus neque, lacinia sit amet imperdiet in, condimentum sit amet purus. Ut ornare erat at dolor rhoncus dignissim. Nunc blandit ligula ut dolor posuere,
                ac tempor quam venenatis.

                Duis fringilla consequat elit eu tristique. Maecenas magna sapien, efficitur vel fermentum at, aliquam et metus. Pellentesque nec magna ac eros tristique aliquam eget et erat. Ut ac
                est nibh. Donec condimentum facilisis porttitor. Sed rhoncus viverra est sed fringilla. Pellentesque vel interdum eros. Etiam hendrerit nisi ultricies, facilisis metus ut, aliquet
                ipsum. Integer quis mauris rutrum magna luctus laoreet vitae eu mauris. Suspendisse potenti.

                Phasellus sollicitudin pulvinar fermentum. Aenean eu nisi tincidunt massa maximus sagittis. Maecenas quis odio pulvinar, vulputate purus laoreet, aliquam metus. Proin quis elit
                commodo, suscipit tellus id, tempus nisl. Nunc arcu erat, gravida quis elementum sit amet, placerat id erat. Proin sit amet lectus turpis. Aliquam tempus eget sem a pellentesque. Sed
                velit sem, viverra quis interdum ut, sodales convallis ex. Cras eu dapibus urna, ac ultrices nulla. Aliquam et neque sem. Fusce iaculis massa a ante cursus, a facilisis augue
                ullamcorper. Fusce aliquet, lorem eget fringilla pretium, eros lectus feugiat sapien, in varius libero magna ut elit. Nam quis ultricies magna. Aenean molestie mi eu sodales luctus.

                Fusce malesuada turpis eget justo tristique, quis suscipit mauris malesuada. Morbi fringilla nulla lacus, eu volutpat justo faucibus et. Cras et mauris non arcu tempor aliquam sit amet
                quis augue. Fusce interdum nulla quis porta sagittis. Aliquam finibus justo non congue porttitor. Praesent scelerisque rutrum tortor a scelerisque. Curabitur fringilla fermentum nisi
                sit amet condimentum. Curabitur mattis dignissim arcu, ac dictum metus mollis sit amet. Nullam tincidunt vitae diam vel blandit. Mauris in sapien vel mi pretium malesuada. Pellentesque
                non volutpat justo, in dapibus lectus. Pellentesque mi lectus, gravida ut leo nec, tempor tincidunt libero.

                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pellentesque sit amet purus vitae sodales. Nulla vitae libero eget nibh venenatis convallis accumsan non nisl.
                Suspendisse est magna, commodo et bibendum id, egestas non dui. Nam mauris leo, commodo ut facilisis quis, congue non justo. Vestibulum tempus dapibus massa sed pulvinar. Sed finibus
                consectetur ante quis blandit. Aenean a vehicula eros, mollis faucibus augue. Fusce venenatis pellentesque nisi.

                Vivamus lacus leo, mollis eget malesuada et, tempus at eros. Nam hendrerit non augue non tristique. Donec dui risus, feugiat nec hendrerit efficitur, blandit a nisi. Vivamus pretium
                ultrices neque a bibendum. Ut lectus neque, lacinia sit amet imperdiet in, condimentum sit amet purus. Ut ornare erat at dolor rhoncus dignissim. Nunc blandit ligula ut dolor posuere,
                ac tempor quam venenatis.

                Duis fringilla consequat elit eu tristique. Maecenas magna sapien, efficitur vel fermentum at, aliquam et metus. Pellentesque nec magna ac eros tristique aliquam eget et erat. Ut ac
                est nibh. Donec condimentum facilisis porttitor. Sed rhoncus viverra est sed fringilla. Pellentesque vel interdum eros. Etiam hendrerit nisi ultricies, facilisis metus ut, aliquet
                ipsum. Integer quis mauris rutrum magna luctus laoreet vitae eu mauris. Suspendisse potenti.

                Phasellus sollicitudin pulvinar fermentum. Aenean eu nisi tincidunt massa maximus sagittis. Maecenas quis odio pulvinar, vulputate purus laoreet, aliquam metus. Proin quis elit
                commodo, suscipit tellus id, tempus nisl. Nunc arcu erat, gravida quis elementum sit amet, placerat id erat. Proin sit amet lectus turpis. Aliquam tempus eget sem a pellentesque. Sed
                velit sem, viverra quis interdum ut, sodales convallis ex. Cras eu dapibus urna, ac ultrices nulla. Aliquam et neque sem. Fusce iaculis massa a ante cursus, a facilisis augue
                ullamcorper. Fusce aliquet, lorem eget fringilla pretium, eros lectus feugiat sapien, in varius libero magna ut elit. Nam quis ultricies magna. Aenean molestie mi eu sodales luctus.

                Fusce malesuada turpis eget justo tristique, quis suscipit mauris malesuada. Morbi fringilla nulla lacus, eu volutpat justo faucibus et. Cras et mauris non arcu tempor aliquam sit amet
                quis augue. Fusce interdum nulla quis porta sagittis. Aliquam finibus justo non congue porttitor. Praesent scelerisque rutrum tortor a scelerisque. Curabitur fringilla fermentum nisi
                sit amet condimentum. Curabitur mattis dignissim arcu, ac dictum metus mollis sit amet. Nullam tincidunt vitae diam vel blandit. Mauris in sapien vel mi pretium malesuada. Pellentesque
                non volutpat justo, in dapibus lectus. Pellentesque mi lectus, gravida ut leo nec, tempor tincidunt libero.

                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pellentesque sit amet purus vitae sodales. Nulla vitae libero eget nibh venenatis convallis accumsan non nisl.
                Suspendisse est magna, commodo et bibendum id, egestas non dui. Nam mauris leo, commodo ut facilisis quis, congue non justo. Vestibulum tempus dapibus massa sed pulvinar. Sed finibus
                consectetur ante quis blandit. Aenean a vehicula eros, mollis faucibus augue. Fusce venenatis pellentesque nisi.

                Vivamus lacus leo, mollis eget malesuada et, tempus at eros. Nam hendrerit non augue non tristique. Donec dui risus, feugiat nec hendrerit efficitur, blandit a nisi. Vivamus pretium
                ultrices neque a bibendum. Ut lectus neque, lacinia sit amet imperdiet in, condimentum sit amet purus. Ut ornare erat at dolor rhoncus dignissim. Nunc blandit ligula ut dolor posuere,
                ac tempor quam venenatis.

                Duis fringilla consequat elit eu tristique. Maecenas magna sapien, efficitur vel fermentum at, aliquam et metus. Pellentesque nec magna ac eros tristique aliquam eget et erat. Ut ac
                est nibh. Donec condimentum facilisis porttitor. Sed rhoncus viverra est sed fringilla. Pellentesque vel interdum eros. Etiam hendrerit nisi ultricies, facilisis metus ut, aliquet
                ipsum. Integer quis mauris rutrum magna luctus laoreet vitae eu mauris. Suspendisse potenti.

                Phasellus sollicitudin pulvinar fermentum. Aenean eu nisi tincidunt massa maximus sagittis. Maecenas quis odio pulvinar, vulputate purus laoreet, aliquam metus. Proin quis elit
                commodo, suscipit tellus id, tempus nisl. Nunc arcu erat, gravida quis elementum sit amet, placerat id erat. Proin sit amet lectus turpis. Aliquam tempus eget sem a pellentesque. Sed
                velit sem, viverra quis interdum ut, sodales convallis ex. Cras eu dapibus urna, ac ultrices nulla. Aliquam et neque sem. Fusce iaculis massa a ante cursus, a facilisis augue
                ullamcorper. Fusce aliquet, lorem eget fringilla pretium, eros lectus feugiat sapien, in varius libero magna ut elit. Nam quis ultricies magna. Aenean molestie mi eu sodales luctus.

                Fusce malesuada turpis eget justo tristique, quis suscipit mauris malesuada. Morbi fringilla nulla lacus, eu volutpat justo faucibus et. Cras et mauris non arcu tempor aliquam sit amet
                quis augue. Fusce interdum nulla quis porta sagittis. Aliquam finibus justo non congue porttitor. Praesent scelerisque rutrum tortor a scelerisque. Curabitur fringilla fermentum nisi
                sit amet condimentum. Curabitur mattis dignissim arcu, ac dictum metus mollis sit amet. Nullam tincidunt vitae diam vel blandit. Mauris in sapien vel mi pretium malesuada. Pellentesque
                non volutpat justo, in dapibus lectus. Pellentesque mi lectus, gravida ut leo nec, tempor tincidunt libero.
            </main>
        </div>

        <aside class="col-lg-4 pr-lg-0 pl-lg-3">
            <a id="ficheTarget"></a>
            <div id="fiche" class="pt-4">
                <ul class="nav nav-tabs cq-fiche-tabs" id="ficheTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="info-tab" data-toggle="tab" href="#ficheInfo" role="tab" aria-controls="Infos" aria-selected="true"><i class="fas fa-info mr-2"></i> Fiche</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#ficheContact" role="tab" aria-controls="Contact" aria-selected="false"><i class="fas fa-user-edit mr-2"></i>
                            Contact</a>
                    </li>
                </ul>

                <div class="tab-content" id="ficheTabContent">
                    <div class="tab-pane fade show active" id="ficheInfo" role="tabpanel" aria-labelledby="info-tab">
                        <div class="card cq-fiche">
                            <img class="card-img-top" src="http://lachouquette.ch/wp-content/uploads/2019/03/JacquesGamblin_NicolasGerardin_4.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h1 class="card-title h4">Théâtre de Beausobre</h1>
                                <p class="card-text">Le théatre de Morges qui balbalbalbla</p>
                                <p class="mb-1"><a href="https://maps.google.com/?q=Avenue de Vertou 2, 1110 Morges" title="Ouvrir avec Google maps" target="_blank"><i
                                                class="fas fa-map-marker-alt pr-1"></i> Avenue de Vertou 2, 1110 Morges</a></p>
                                <p class="mb-1"><a href="tel:021 804 15 65" title="Téléphone"><i class="fas fa-phone-square pr-1"></i> 021 804 15 65</a></p>
                                <p class="mb-1"><a href="http://beausobre.ch/" title="Site internet" target="_blank"><i class="fas fa-desktop pr-1"></i> Site internet</a></p>
                                <p class="mb-1"><a href="mailto:info@beausobre.ch" title="EMail"><i class="fas fa-at pr-1"></i> Email</a></p>
                                <p class="mt-3 mb-0">
                                    <span class="mr-2">Réseaux :</span>
                                    <a href="https://facebook.com/beausobre.ch/" title="Facebook" target="_blank" class="mr-2"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/theatre_de_beausobre/" title="Instagram" target="_blank" class="mr-2"><i class="fab fa-instagram"></i></a>
                                </p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Prix : <span class="cq-fiche-price cq-fiche-price-selected">$$$</span><span class="cq-fiche-price">$$</span></li>
                                <li class="list-group-item">
                                    <p class="mb-2">Horaires :</p>
                                    <ul>
                                        <li>Lundi-Vendredi : 19-23h</li>
                                        <li>Samedi : 9-23h</li>
                                        <li>Dimanche : 11-20h</li>
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    <p class="mb-2">Infos :</p>
                                    <p class="mb-0">
                                        <i class="fas fa-child mr-2"></i><i class="fas fa-wheelchair mr-2"></i><i class="fas fa-wifi mr-2"></i>
                                    </p>
                                </li>
                            </ul>
                            <div class="card-footer text-center">
                                CHOUQUETTISÉ
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ficheContact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="card cq-fiche-contact">
                            <div class="card-body">
                                <h2 class="card-title h4">Contact le propriétaire</h2>
                                <form>
                                    <div class="form-group">
                                        <label for="contactSenderName">Ton prénom / nom</label>
                                        <input class="form-control" id="contactSenderName">
                                    </div>
                                    <div class="form-group">
                                        <label for="contactSenderMail">Ton mail</label>
                                        <input type="email" class="form-control" id="contactSenderMail">
                                    </div>
                                    <div class="form-group">
                                        <label for="contactSenderContent">Ton message</label>
                                        <textarea class="form-control" id="contactSenderContent" rows="5"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <div class="row cq-single-author mt-3 mt-lg-5">
        <div class="col">
            <h3 class="mb-3">Auteur</h3>
            <div class="media">
                <img class="rounded-circle mr-3" src="http://0.gravatar.com/avatar/ff03948ae1055f3da0cf6b223729cf54?s=140&amp;d=blank&amp;r=g" alt="Justine" width="80" height="80">
                <div class="media-body">
                    <h5 class="mt-0">Justine</h5>
                    Bourguignonne de naissance mais vaudoise de cœur. Passionnée de cinéma et de littérature, je t'embarque dans mes aventures à Lausanne ou Morges.
                </div>
            </div>
        </div>
    </div>

    <div class="row cq-single-similar mt-3 mt-lg-5">
        <div class="col">
            <h3 class="mb-3">Articles similaires</h3>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $tops_posts = new WP_Query('posts_per_page=10');
                    if ($tops_posts->have_posts()) :
                        while ($tops_posts->have_posts()) :
                            $tops_posts->the_post();
                            ?>
                            <div class="swiper-slide bg-dark text-white"> <?php
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

    <?php if (comments_open() || get_comments_number()) : ?>
        <div class="row cq-single-comments mt-3 mt-lg-5">
            <div class="col">
                <h3 class="mb-3">Commentaires</h3>
                <?php comments_template(); ?>
            </div>
        </div>
    <?php endif; ?>
</article>

<?php get_footer(); ?>