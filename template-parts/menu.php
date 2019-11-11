<header class="cq-menu">
    <nav class="navbar fixed-top navbar-chouquette-light navbar-expand-md">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarChouquette" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand mx-auto" href="/"><?php bloginfo('name'); ?></a>

        <div class="collapse navbar-collapse" id="navbarChouquette">
            <form action='/' class="d-md-none mb-2">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="search" name="s" placeholder="Recherche" aria-label="Search" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <?php chouquette_navbar_nav(); ?>
            <div class="navbar-divider"></div>
            <div class="navbar-sn mr-3">
                <a href="<?php echo esc_url(CQ_SN_FACEBOOK); ?>" title="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="<?php echo esc_url(CQ_SN_INSTAGRAM); ?>" title="Instagram" target="_blank"><i class="fab fa-instagram ml-3"></i></a>
                <a href="#" title="Newsletter" data-toggle="modal" data-target="#newsletterModal"><i class="far fa-envelope ml-3"></i></a>
                <a href="<?php bloginfo('atom_url'); ?>" title="RSS" target="_blank"><i class="fas fa-rss ml-3"></i></a>
                <a href="#" title="Recherche" class="d-none d-md-inline-block" data-toggle="modal" data-target="#searchModal"><i class="fas fa-search ml-3"></i></a>
            </div>
        </div>
    </nav>
</header>

<!-- Search Modal -->
<div class="modal fade cq-modal" id="searchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="/">
                    <div class="input-group">
                        <input class="form-control" type="search" name="s" placeholder="Mots clefs ?" aria-label="Mots clefs ?" autofocus required/>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>