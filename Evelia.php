<?php

/*
 * Plugin Name:       Evelia
 * Plugin URI:        https://git.crystalyx.net/camelia-studio/UWU_Evelia
 * Description:       A Plugin to manage events from Discord.
 * Version:           1.0.11
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Camélia Studio
 * Author URI:        https://camelia-studio.org
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       Evelia
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

define('EVELIA_VERSION', '1.0.11');
define('EVELIA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EVELIA_PLUGIN_URL', plugin_dir_url(__FILE__));


// Inclure la classe principale
require_once EVELIA_PLUGIN_DIR . 'includes/EveliaMain.php';

// Initialiser le plugin
function eveliaInit() {
    EveliaMain::getInstance();
}
add_action('plugins_loaded', 'eveliaInit');