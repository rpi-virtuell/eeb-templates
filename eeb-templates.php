<?php
/**
Plugin Name: EEB Templates
Plugin URI: https://github.com/rpi-virtuell/eeb-templates
Description: Stellt Views zur Verfügung, die unter anderem auch von FacetWP genutzt werden
Version: 1.0
Author: Daniel Reintanz
License: GPLv2
 */
defined('ABSPATH') or die('Direkter Zugriff auf Skripte ist nicht erlaubt.');
define('EEB_TEMPLATE_PLUGIN_DIR', plugin_dir_path(__FILE__));
include (EEB_TEMPLATE_PLUGIN_DIR. '/views/personen.php');


function run_eeb_plugin(){
    wp_enqueue_style('person-view', plugin_dir_url(__FILE__).'/assets/css/person-view.css',array(), '1.0');
    add_shortcode('eeb-person-view','display_person_view' );

}
run_eeb_plugin();

