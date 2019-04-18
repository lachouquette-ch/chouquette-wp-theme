<?php
/**
 * Functions to handle POSTS (from HTML forms)
 *
 * @package Chouquette_thème
 */

if (!function_exists('chouquette_posts_fiche_contact')) :
    function chouquette_posts_fiche_contact()
    {
        if (!empty ($_POST)) {
            if (isset($_POST['fiche-id'])) {
                $contact_mail = get_field(CQ_FICHE_MAIL, $_POST['fiche-id']);
                chouquette_recaptcha(
                    function () use ($contact_mail) {
                        $result = chouquette_mail($_POST['contact-name'], $_POST['contact-email'], $contact_mail, sprintf('Message de %s via lachouquette.ch', $_POST['contact-name']), $_POST['contact-content']);
                        if ($result) {
                            chouquette_ref_redirect(array('success' => base64_encode('Email envoyé à ' . $contact_mail)));
                        } else {
                            chouquette_ref_redirect(array('failure' => base64_encode("Echec de l'envoi de l'email à " . $contact_mail)));
                        }
                    },
                    function () use ($contact_mail) {
                        chouquette_ref_redirect(array('failure' => base64_encode("Problème lors de l'envoi de l'email à " . $contact_mail)));
                    }
                );
            }
        }
    }
endif;
add_action('admin_post_nopriv_fiche_contact', 'chouquette_posts_fiche_contact');
add_action('admin_post_fiche_contact', 'chouquette_posts_fiche_contact');