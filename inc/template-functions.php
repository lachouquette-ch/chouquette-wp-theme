<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_menu_items')) :
    /**
     * Retrieve chouquette menu items
     */
    function chouquette_menu_items()
    {
        $result = array();

        // get menu items
        if (isset (get_nav_menu_locations()[CQ_PRIMARY_MENU])) {
            $primary_menu_id = get_nav_menu_locations()[CQ_PRIMARY_MENU];
            $menu = wp_get_nav_menu_object($primary_menu_id);
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            return $menu_items;
        } else {
            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
        }
    }
endif;

if (!function_exists('chouquette_get_taxonomy_terms')) :
    /**
     * Get taxonomy terms using https://developer.wordpress.org/reference/functions/get_the_terms/.
     *
     * @param WP_Post $post The given post
     * @param string $taxonomy the given taxonomy
     *
     * @return array of WP_Term of empty array if nothing. Return terms also get the logo field on attribute 'logo'
     */
    function chouquette_get_taxonomy_terms(WP_Post $post, string $taxonomy)
    {
        $terms = get_the_terms($post, $taxonomy);
        if ($terms instanceof WP_Error) {
            error_log($terms->get_error_message() . ' for ' . $taxonomy);
            return;
        }
        if (!$terms) $terms = [];
        // add logo field to term object
        foreach ($terms as $term) {
            $term->logo = get_field(CQ_MENU_LOGO_SELECTOR, $term);
        }
        return $terms;
    }
endif;

if (!function_exists('chouquette_mail')) :
    /**
     * Send email. Wrapper on https://developer.wordpress.org/reference/functions/wp_mail with fallback, from and BCC trick
     *
     * Wraps message (and subject) with Chouquette information.
     * Set proper header (BCC, Reply-To)
     *
     * @param $from_name string name of sender
     * @param $from string email of sender
     * @param $to string dest. email
     * @param $subject string email subject
     * @param $message string email content
     *
     * @return true/false if the mail was property sent
     */
    function chouquette_mail(string $from_name, string $from, string $to, string $subject, string $message)
    {
        /* Message body */
        $body_template = <<<EOT
            <html>
            <head>
                <title>%s</title>
            </head>
            <body aria-readonly="false">
                <p>%s</p>
                <p><em>Cet email vous a été envoyé depuis </em><a href="%s">%s</a></p>
                <div style="text-align: center">
                    <a href="%s" name="%s">
                    <img src="%s">
                    <p>%s</p>
                    </a>
                </div>
            </body>
            </html>
EOT;

        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'thumbnail');
        $body = sprintf($body_template,
            $subject, nl2br(stripslashes($message)),
            home_url('/'), home_url('/'),
            home_url('/'), get_bloginfo('name'),
            $logo[0], get_bloginfo('description'));

        /* Headers */
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            sprintf('Reply-To: %s <%s>', $from_name, $from)
        );
        if (MAIL_BCC_FALLBACK) {
            $headers[] = 'Bcc: ' . MAIL_FALLBACK;
        }
        if (!MAIL_ACTIVATE) { // security for development. Send email to fallback instead of real dest.
            $to = MAIL_FALLBACK;
        }

        return wp_mail($to, $subject, $body, $headers);
    }
endif;

if (!function_exists('chouquette_recaptcha')) :
    /**
     * Verify recaptcha and execute proper callback
     *
     * @param $on_success function function to call on success
     * @param $on_failure function function to call on failure
     * @param $score_success float min repatcha score to distinguish success
     *
     * @throws Exception if something's wrong with recaptcha
     */
    function chouquette_recaptcha($on_success, $on_failure, $score_success = 0.5)
    {
        if (!is_callable($on_success)) {
            throw new Exception('chouquette_recaptcha on_success should be callable');
        }
        if (!is_callable($on_failure)) {
            throw new Exception('chouquette_recaptcha on_failure should be callable');
        }

        if (isset($_POST['recaptcha-response'])) {
            // Build POST request:
            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_response = $_POST['recaptcha-response'];

            // Make and decode POST request:
            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . CQ_RECAPTCHA_SECRET . '&response=' . $recaptcha_response);
            $recaptcha = json_decode($recaptcha);

            // Take action based on the score returned:
            if (!$recaptcha->success) {
                throw new Exception('Erreur recaptcha : ' . join(', ', $recaptcha->{'error-codes'}));
            }
            if (isset($recaptcha->score) && $recaptcha->score >= $score_success) {
                $on_success($recaptcha);
            } else {
                $on_failure($recaptcha);
            }
        } else {
            throw new Exception("Couldn't find recaptcha in POST");
        }
    }
endif;

if (!function_exists('chouquette_ref_redirect')) :
    /**
     * Redirect to referer
     *
     * @param $query_args array query arguments to pass to redirection
     */
    function chouquette_ref_redirect($status, $message)
    {
        setcookie(CQ_COOKIE_PREFIX . 'message_status', $status, time() + 10, '/'); // 10 seconds
        setcookie(CQ_COOKIE_PREFIX . 'message_content', base64_encode($message), time() + 10, '/'); // 10 seconds
        if (wp_get_referer()) {
            wp_safe_redirect(wp_get_referer(), 303);
        } else {
            wp_safe_redirect(get_home_url(), 303);
        }
    }
endif;

if (!function_exists('chouquette_load_template_part')) :
    /**
     * Load a template and return its as string
     *
     * @param string $template_name The slug name for the generic template.
     * @param string $part_name The name of the specialised template.
     * @return string template content
     */
    function chouquette_load_template_part($template_name, $part_name = null)
    {
        ob_start();
        get_template_part($template_name, $part_name);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
endif;

if (!(function_exists('chouquette_get_attachment_by_title'))) :
    function chouquette_get_attachment_by_title($post_name)
    {
        $args = array(
            'posts_per_page' => 1,
            'post_type' => 'attachment',
            'name' => trim($post_name),
        );

        $get_attachment = new WP_Query($args);
        if (!$get_attachment || !isset($get_attachment->posts, $get_attachment->posts[0])) {
            return false;
        }

        return $get_attachment->posts[0];
    }
endif;