<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_navbar_nav')) :
    /*
     * Prints the navbar composed of ul/li items (nav-item)
     */
    function chouquette_navbar_nav(string $img_color = 'white', string $img_color_active = 'yellow')
    {
        $active_category_id = !empty(get_queried_object()) ? get_queried_object()->term_id : null;

        // get menu items
        $menu_items = chouquette_menu_items();
        if (!empty ($menu_items)) {
            echo '<ul class="navbar-nav mr-auto">';
            foreach ($menu_items as $menu_item) :
                echo sprintf('<li class="nav-item %s">', $active_category_id == $menu_item->object_id ? 'active' : '');
                echo sprintf('<a class="nav-link" href="%s" title="%s">%s %s</a>',
                    esc_url($menu_item->url),
                    $menu_item->description,
                    chouquette_taxonomy_logo($menu_item, $active_category_id == $menu_item->object_id ? $img_color_active : $img_color, 'thumbnail', array('nav-logo ml-lg-3 mr-2')),
                    $menu_item->title);
                echo '</li>';
            endforeach;
            echo '</ul>';
        } else {
            trigger_error(sprintf("Menu principal du thème '%s' non renseigné", CQ_PRIMARY_MENU), E_USER_WARNING);
        }
    }
endif;

if (!function_exists('chouquette_header_alert')) :
    /**
     * Prints an alert. Should be on top of page (after menu)
     *
     * @param string $alert_type the alert type. Should be either  'success', 'danger', 'warning' or 'info'
     * @param string $alert_message the alert message content
     */
    function chouquette_header_alert(string $alert_type, string $alert_message)
    {
        echo "<div class='alert alert-{$alert_type} alert-dismissible fade show mb-0 pt-4' role='alert'>{$alert_message}";
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '</div>';
    }
endif;

if (!function_exists('chouquette_fiche_openings')) :
    /**
     * Prints fiche openings. Also flatten openings if consecutive days have the same.
     *
     * @param array $fiche_fields all fiche fields to pick from
     */
    function chouquette_fiche_openings(array $fiche_fields)
    {
        echo '<ul>';
        $raw_planning = array(
            $fiche_fields[CQ_FICHE_OPENING_MONDAY],
            $fiche_fields[CQ_FICHE_OPENING_TUESDAY],
            $fiche_fields[CQ_FICHE_OPENING_WEDNESDAY],
            $fiche_fields[CQ_FICHE_OPENING_THURSDAY],
            $fiche_fields[CQ_FICHE_OPENING_FRIDAY],
            $fiche_fields[CQ_FICHE_OPENING_SATURDAY],
            $fiche_fields[CQ_FICHE_OPENING_SUNDAY],
        );
        $planning_labels = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

        $from = null;
        foreach ($raw_planning as $index => $opening) {
            if ($index == count($raw_planning) - 1 || $raw_planning[$index] != $raw_planning[$index + 1]) {
                if (str_replace('"', '', $raw_planning[$index]) == CQ_FICHE_OPENING_CLOSED) {
                    $opening = 'Fermé';
                }
                echo sprintf('<li>%s%s : %s</li>', (!is_null($from) ? $planning_labels[$from] . '-' : ''), $planning_labels[$index], $opening);
                $from = null;
            } elseif (is_null($from)) {
                $from = $index;
            }
        }
        echo '</ul>';
    }
endif;

if (!function_exists('chouquette_taxonomy_logo')) :
    /**
     * Prints the taxonomy logo (if any)
     *
     * @param object $taxonomy the taxonomy. Should have a 'logo' attribute (array) with the id of the image
     * @param string $color the color. Only 'white', 'black' or 'yellow'
     * @param string $size the WP size. Default is thumbnail
     * @param array $classes the classes to add to the img tag
     */
    function chouquette_taxonomy_logo(object $taxonomy, string $color = 'yellow', string $size = 'thumbnail', array $classes = array())
    {
        switch ($color) {
            case 'white':
                $logo_id = get_field(CQ_CATEGORY_LOGO_WHITE, chouquette_acf_generate_post_id($taxonomy));
                break;
            case 'black':
                $logo_id = get_field(CQ_CATEGORY_LOGO_BLACK, chouquette_acf_generate_post_id($taxonomy));
                break;
            case 'yellow':
                $logo_id = get_field(CQ_CATEGORY_LOGO_YELLOW, chouquette_acf_generate_post_id($taxonomy));
                break;
            default:
                throw new Exception("$color is undefined");
        }
        $image_src = wp_get_attachment_image_src($logo_id, $size)[0];
        return sprintf('<img src="%s" alt="%s" title="%s" class="%s" />', $image_src, $taxonomy->description, $taxonomy->name, join(" ", $classes));
    }
endif;

if (!function_exists('chouquette_location_options')) :
    /**
     * Generate location options for select menu
     */
    function chouquette_location_options($selectedLocation = null)
    {
        $terms = get_terms(array(
            'taxonomy' => CQ_TAXONOMY_LOCATION,
            'parent' => 0,
            'orderby' => 'count',
            'order' => 'DESC'
        ));
        foreach ($terms as $term) {
            $attr_selected = isset($selectedLocation) && $selectedLocation->slug === $term->slug ? 'selected' : '';
            echo "<option title='{$term->name}' value='{$term->slug}' style='font-weight: bold' {$attr_selected}>{$term->name}</option>";
            $subterms = get_terms(array(
                'taxonomy' => CQ_TAXONOMY_LOCATION,
                'parent' => $term->term_id,
                'orderby' => 'name'
            ));
            foreach ($subterms as $subterm) {
                $attr_selected = isset($selectedLocation) && $selectedLocation->slug === $subterm->slug ? 'selected' : '';
                echo "<option title='{$subterm->name}' value='{$subterm->slug}' {$attr_selected}>&nbsp;&nbsp; {$subterm->name}</option>";
            }
        }
    }
endif;
