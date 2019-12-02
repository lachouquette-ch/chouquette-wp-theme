<?php get_header(); ?>
    <div class="container cq-404 py-5 text-center">
        <div class="cq-404-msg mb-5">
            <p><i class="fas fa-exclamation-triangle"></i> Ooops</p>
            <p>On a rien pu trouvé (404). Désolé...</p>
        </div>
        <div>
            <p>Envie de découvrir les nouveautés Chouquette ? <a class='link-secondary' title='Les nouveautés Chouquette' href="/">C'est par ici !</a></p>
            <?php
            $tag = get_query_var('tag');
            if (!empty($tag)) {
                $tag = preg_replace('[-+]', ' ', $tag);
                $search_url = add_query_arg('s', urlencode($tag), '/');
                echo "<p>Une recherche sur '$tag' ? <a class='link-secondary' title='Recherche $tag' href='$search_url'>C'est par là !</a></p>";
            }
            ?>
            <p>Sinon t'as toujours les catégories dans le menu pour t'aider à naviguer <i class="fas fa-ship"></i></p>
        </div>
    </div>
<?php

wp_enqueue_script('404', get_template_directory_uri() . '/dist/default.js', null, CQ_THEME_VERSION, true);

get_footer();
