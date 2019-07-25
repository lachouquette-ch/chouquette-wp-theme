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
                        $result = chouquette_mail($_POST['contact-name'], $_POST['contact-email'], $contact_mail, "Message de {$_POST['contact-name']} via lachouquette.ch", $_POST['contact-content']);
                        if ($result) {
                            chouquette_ref_redirect('success', 'Email envoyé à ' . $contact_mail);
                        } else {
                            chouquette_ref_redirect('failure', "Echec de l'envoi de l'email à " . $contact_mail);
                        }
                    },
                    function () use ($contact_mail) {
                        chouquette_ref_redirect('failure', "Problème de validation de ton message (recaptcha). Merci de réessayer plus tard.");
                    }
                );
            }
        }
    }
endif;
add_action('admin_post_nopriv_fiche_contact', 'chouquette_posts_fiche_contact');
add_action('admin_post_fiche_contact', 'chouquette_posts_fiche_contact');

if (!function_exists('chouquette_posts_contact')) :
    function chouquette_posts_contact()
    {
        if (!empty ($_POST)) {
            // assert post content
            if (!isset($_POST['contact-name']) || !isset($_POST['contact-email']) || !isset($_POST['contact-subject']) || !isset($_POST['contact-localisation']) || !isset($_POST['contact-content'])) {
                chouquette_ref_redirect('failure', "Le formulaire n'est pas complet");
                return;
            }

            $localisation = get_term_by('slug', $_POST['contact-localisation'], CQ_TAXONOMY_LOCATION);
            $ambassador = get_field(CQ_LOCALISATION_AMBASSADOR, chouquette_acf_generate_post_id($localisation));
            if ($ambassador) {
                $contact_mail = $ambassador->user_email;
            } else {
                $contact_mail = MAIL_FALLBACK;
            }
            chouquette_recaptcha(
                function () use ($contact_mail) {
                    $result = chouquette_mail($_POST['contact-name'], $_POST['contact-email'], $contact_mail, $_POST['contact-subject'], $_POST['contact-content']);
                    if ($result) {
                        chouquette_ref_redirect('success', 'Merci beaucoup pour ton message. Nous ferons au mieux pour te répondre dans les plus brefs délais.');
                    } else {
                        chouquette_ref_redirect('failure', "Echec de l'envoi de l'email à " . $contact_mail);
                    }
                },
                function () use ($contact_mail) {
                    chouquette_ref_redirect('failure', "Problème de validation de ton message (recaptcha). Merci de réessayer plus tard.");
                }
            );
        }
    }
endif;
add_action('admin_post_nopriv_contact', 'chouquette_posts_contact');
add_action('admin_post_contact', 'chouquette_posts_contact');

if (!function_exists('chouquette_posts_fiche_report')) :
    function chouquette_posts_fiche_report()
    {
        if (!empty ($_POST)) {
            if (isset($_POST['fiche-id'])) {
                $fiche_title = get_the_title($_POST['fiche-id']);
                chouquette_recaptcha(
                    function () use ($fiche_title) {
                        $fiche_edit_link = get_edit_post_link($_POST['fiche-id']);
                        $result = chouquette_mail('do-not-reply', 'do-not-reply@lachouquette.ch', MAIL_FALLBACK, 'Commentaire sur la fiche ' . $fiche_title, $_POST['report-text'] . "<br/><a href='${fiche_edit_link}' target='_blank'>Editer la fiche</a>");
                        if ($result) {
                            chouquette_ref_redirect('success', sprintf('Merci beaucoup pour ton message concernant la fiche %s. Nous le traiterons dans les plus brefs délais :-)', $fiche_title));
                        } else {
                            chouquette_ref_redirect('failure', "Problème lors de l'envoi de ton commantaire sur la fiche " . $fiche_title);
                        }
                    },
                    function () use ($fiche_title) {
                        chouquette_ref_redirect('failure', "Problème de validation de ton message (recaptcha). Merci de réessayer plus tard.");
                    }
                );
            }
        }
    }
endif;
add_action('admin_post_nopriv_fiche_report', 'chouquette_posts_fiche_report');
add_action('admin_post_fiche_report', 'chouquette_posts_fiche_report');