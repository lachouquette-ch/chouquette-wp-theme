<?php
/**
 * Template Name: Team
 */

get_header();
?>

<div class="container cq-team mb-5">
    <div class="row cq-team-title">
        <div class="col text-center">
            <h1 class="mb-3 cq-font"><?php the_title() ?></h1>
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
    echo '<h5 class="mt-3">' . $member->display_name . '</h5>';
    echo '<div>' . get_user_meta($member->ID, 'description', true) . '</div>';
    echo '</div>';
    echo '</div>';

    if ($index % 3 == 2 || $index +1 == count($members)) {
        echo '</div>';
    }
}
echo '</div>';

get_footer();