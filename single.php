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
    <nav class="navbar navbar-chouquette navbar-expand-xl sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarChouquette" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/"><?php bloginfo('name'); ?></a>

        <div class="collapse navbar-collapse" id="navbarChouquette">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="fas fa-cocktail mr-2"></i>Bars et Restos <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-theater-masks mr-2"></i>Culture</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fab fa-angellist mr-2"></i>Loisirs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-shopping-bag mr-2"></i>Shopping</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-grin-hearts mr-2"></i>Les Chouchous</a>
                </li>
            </ul>
            <div class="navbar-divider"></div>
            <div class="navbar-sn mr-3">
                <a href="<?php echo esc_url(CHOUQUETTE_SN_FACEBOOK); ?>" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="<?php echo esc_url(CHOUQUETTE_SN_INSTAGRAM); ?>" title="Instagram"><i class="fab fa-instagram ml-2"></i></a>
                <a href="#newsletter" title="Newsletter"><i class="far fa-envelope ml-2"></i></a>
                <a href="<?php bloginfo('atom_url'); ?>" title="RSS"><i class="fas fa-rss ml-2"></i></a>
            </div>
            <form class="form-inline">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="search" placeholder="Recherche" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</header>

<article class="container">
    <header class="single-cover">
        <img src="" title="post-image">
        <img src="" title="author">
        <span>par Cyrielle</span>
        <span>dans Catégories / ... / ...</span>
    </header>
    <h1>Le titre</h1>
    <main>
        <aside>
            <img src="" title="fiche-img">
            <span>Infos</span>
        </aside>
        <p>Mon contenu</p>
    </main>
    <footer>
        <div>Auteur</div>
        <div>Article similaire</div>
        <div>Article similaire</div>
        <div>Commentaire</div>
    </footer>
</article>

<footer>
    Footer
</footer>

<?php wp_footer(); ?>
</body>
</html>