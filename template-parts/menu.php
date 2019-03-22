<header class="cq-menu">
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
        <a href="#ficheTarget" class="py-1 px-3">
            <small><i class="fas fa-info mr-1"></i> Fiche</small>
        </a>
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