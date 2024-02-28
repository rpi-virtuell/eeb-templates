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
    $enqueues = [
        'styles' => [
            'eeb-general-view' => '/assets/css/general-view.css',
            'eeb-person-view' => '/assets/css/person-view.css',
            'eeb-magazine-view' => '/assets/css/magazine-view.css',
            'eeb-organisation-list-view' => '/assets/css/organisationen-list-view.css',
            'eeb-carousel' => '/assets/css/carousel.css'

        ],
    ];
    if (!function_exists('get_plugin_data')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $plugin_data = get_plugin_data(__FILE__);

    $plugin_version = $plugin_data['Version'];
    foreach ($enqueues['styles'] as $style_handle => $style_path) {
        wp_enqueue_style($style_handle, plugin_dir_url(__FILE__) . $style_path, [], $plugin_version . '.' . filemtime(__DIR__ . $style_path));
    }
    //Personen Views
    add_shortcode('eeb-person-view', 'display_person_view');
    add_shortcode('eeb-ansprechpartner-view', 'display_ansprechpartner');

    //Magazine Views
    add_shortcode('eeb-aktuelle-ausgabe', 'display_current_publication');
    add_shortcode('eeb-freie-artikel-der-ausgabe', 'display_free_articles_of_publication');
    add_shortcode('eeb-inhaltsverzeichnis', 'display_magazin_iframe');
    add_shortcode('eeb-vergangene-ausgaben', 'display_older_publications');

    //Blocksy Hooks
    add_action('blocksy:single:content:bottom', array('Eeb_General_Helper', 'display_logo_postfix'));
    add_action('blocksy:header:after', array('Eeb_General_Helper', 'display_magazin_button'));

    add_action('save_post', 'alter_ausgabe_content', 10, 3);
}

run_eeb_plugin();

