<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chouquette_thème
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h2 class="comments-title">
            <?php
            $chouquette_comment_count = get_comments_number();
            if ('1' === $chouquette_comment_count) {
                printf(
                /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'chouquette'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf( // WPCS: XSS OK.
                /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $chouquette_comment_count, 'comments title', 'chouquette')),
                    number_format_i18n($chouquette_comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'chouquette'); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().


    // as documented in https://codex.wordpress.org/Function_Reference/comment_form

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields = array(
        'author' =>
            '<div class="form-group row">' .
            '<label class="col-sm-4 col-form-label" for="author">' . __('Name') . ($req ? '<span class="required">*</span>' : '') . '</label>' .
            '<div class="col-sm-8"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>' .
            '</div>',
        'email' =>
            '<div class="form-group row">' .
            '<label class="col-sm-4 col-form-label" for="email">' . __('Email') . ($req ? '<span class="required">*</span>' : '') . '</label>' .
            '<div class="col-sm-8"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>' .
            '</div>',
        'url' =>
            '<div class="form-group row">' .
            '<label class="col-sm-4 col-form-label" for="url">' . __('Website') . '</label>' .
            '<div class="col-sm-8"><input class="form-control" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>' .
            '</div>',
    );
    // cookies consent
    if (has_action('set_comment_cookies', 'wp_set_comment_cookies') && get_option('show_comments_cookies_opt_in')) {
        $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
        $fields['cookies'] = '<div class="form-check">' .
            '<input class="form-check-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
            '<label for="wp-comment-cookies-consent">' . __('Save my name, email, and website in this browser for the next time I comment.') . '</label>' .
            '</div>';
    }
    $args = array(
        'class_submit' => 'btn btn-primary',
        'comment_field' =>
            '<div class="form-group"><label for="comment">' . _x('Comment', 'noun') .
            '</label><textarea class="form-control" id="comment" name="comment" rows="5" aria-required="true"></textarea>' .
            '</div>',
        'fields' => apply_filters('comment_form_default_fields', $fields),
        'title_reply_before' => '<h5 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h5>',
    );
    comment_form($args);
    ?>

</div><!-- #comments -->
