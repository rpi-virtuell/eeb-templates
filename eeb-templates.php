<?php
/**
 * Plugin Name: EEB Templates
 * Plugin URI: https://github.com/rpi-virtuell/eeb-templates
 * Description: Stellt Views zur Verfügung, die unter anderem auch von FacetWP genutzt werden
 * Version: 1.0
 * Author: Daniel Reintanz
 * License: GPLv2
 */
defined('ABSPATH') or die('Direkter Zugriff auf Skripte ist nicht erlaubt.');
define('EEB_TEMPLATE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EEB_TEMPLATE_PLUGIN_URL', plugin_dir_url(__FILE__));
include EEB_TEMPLATE_PLUGIN_DIR . '/views/personen.php';
include EEB_TEMPLATE_PLUGIN_DIR . '/views/ansprechpartner.php';
include EEB_TEMPLATE_PLUGIN_DIR . '/views/magazin.php';
include EEB_TEMPLATE_PLUGIN_DIR . 'classes/person-helper.php';
include EEB_TEMPLATE_PLUGIN_DIR . 'classes/eeb-general-helper.php';
include EEB_TEMPLATE_PLUGIN_DIR . 'classes/magazin-helper.php';


function run_eeb_plugin()
{
    wp_enqueue_style('eeb-general-view', plugin_dir_url(__FILE__) . '/assets/css/general-view.css', array(), '1.0');
    wp_enqueue_style('eeb-person-view', plugin_dir_url(__FILE__) . '/assets/css/person-view.css', array(), '1.0');
    wp_enqueue_style('eeb-magazine-view', plugin_dir_url(__FILE__) . '/assets/css/magazine-view.css', array(), '1.0');
    wp_enqueue_style('eeb-organisation-list-view', plugin_dir_url(__FILE__) . '/assets/css/organisationen-list-view.css', array(), '1.0');
    wp_enqueue_style('eeb-carousel', plugin_dir_url(__FILE__) . '/assets/css/carousel.css', array(), '1.0');


    add_shortcode('eeb-person-view', 'display_person_view');
    add_shortcode('eeb-ansprechpartner-view', 'display_ansprechpartner');

    //Magazine view
    add_shortcode('eeb-aktuelle-ausgabe', 'display_current_publication');
    add_shortcode('eeb-freie-artikel-der-ausgabe', 'display_free_articles_of_publication');
    add_shortcode('eeb-inhaltsverzeichnis', 'display_magazin_iframe');



    add_action('blocksy:single:content:bottom', array('Eeb_General_Helper', 'display_logo_postfix'));
    add_action('blocksy:header:after', array('Eeb_General_Helper', 'display_magazin_button'));
//    add_action('blocksy:hero:title:after', 'display_single_magazin_view'); TODO deprecated delete if not needed
    add_action('save_post','alter_ausgabe_content',10, 3);
}

run_eeb_plugin();

