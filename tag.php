<?php
$tag = get_queried_object();
$search_url = add_query_arg('s', urlencode($tag->slug), '/');
if (wp_redirect($search_url)) {
    exit;
}
