<?php


if (!defined('ABSPATH')) {
    exit;
}

class EveliaMain
{
    private static $instance = null;

    private function __construct()
    {
        $this->load_dependencies();
        $this->init_hooks();
    }

    public static function getInstance(): ?EveliaMain
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function load_dependencies(): void
    {
        require_once EVELIA_PLUGIN_DIR . 'includes/EveliaDiscordApi.php';
        require_once EVELIA_PLUGIN_DIR . 'includes/EveliaFrontend.php';
        require_once EVELIA_PLUGIN_DIR . 'includes/EveliaAssets.php';

        if (is_admin()) {
            require_once EVELIA_PLUGIN_DIR . 'admin/EveliaAdmin.php';
            EveliaAdmin::getInstance();
        }

        // Toujours charger le frontend et les assets
        EveliaFrontend::getInstance();
        EveliaAssets::getInstance();
    }

    private function init_hooks(): void
    {
        add_action('init', array($this, 'loadTextdomain'));
    }

    public function loadTextdomain(): void
    {
        load_plugin_textdomain('evelia', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
}