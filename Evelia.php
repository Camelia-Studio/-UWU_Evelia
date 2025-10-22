<?php

/*
 * Plugin Name:       Evelia
 * Plugin URI:        https://camelia-studio.org
 * Description:       A Plugin to manage events from Discord.
 * Version:           1.0.4
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Camélia Studio
 * Author URI:        https://camelia-studio.org
 * License:          MIT
 * License URI:       https://opensource.org/license/mit
 * Text Domain:       evelia
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

define('EVELIA_VERSION', '1.0.4');
define('EVELIA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EVELIA_PLUGIN_URL', plugin_dir_url(__FILE__));


// Inclure la classe principale
require_once EVELIA_PLUGIN_DIR . 'includes/EveliaMain.php';

// Initialiser le plugin
function eveliaInit() {
    EveliaMain::getInstance();
}
add_action('plugins_loaded', 'eveliaInit');