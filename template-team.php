<?php
/**
 * Template Name: Team
 */

get_header();
?>

<div class="container cq-page py-5">
    <div class="row">
        <div class="col">
            <h1><?php the_title() ?></h1>
            <div class="mb-5"><?php the_content(); ?></div>
        </div>
    </div>

<?php
$args = array(
    'role__in' => array('administrator', 'editor', 'author'),
    'orderby' => 'registered'
);
$members = get_users($args);
foreach ($members as $index => $member) {
    if ($index % 3 == 0) {
        echo '<div class="row">';
    }
    echo '<div class="col-sm-4 p-2">';
    echo '<div class="text-center p-3 cq-team-member">';
    echo get_avatar($member->ID, 150, null, $member->display_name, ['class' => 'rounded-circle']);
    echo '<h5 class="mt-3 mb-2 cq-font h2">' . $member->display_name . '</h5>';
    echo '<p class="mb-2 text-center"><em>' . get_field(CQ_USER_ROLE, chouquette_acf_generate_post_id($member)) . '</em></p>';
    echo '<p>' . get_user_meta($member->ID, 'description', true) . '</p>';
    echo '</div>';
    echo '</div>';

    if ($index % 3 == 2 || $index +1 == count($members)) {
        echo '</div>';
    }
}
echo '</div>';

wp_enqueue_script('template-team', get_template_directory_uri() . '/dist/other.js', null, CQ_THEME_VERSION, true);

get_footer();
