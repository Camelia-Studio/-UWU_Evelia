<?php


if (!defined('ABSPATH')) {
    exit;
}

class EveliaMain
{
    private static $instance = null;

    private function __construct()
    {
        $this->loadDependencies();
        $this->initHooks();
    }

    public static function getInstance(): ?EveliaMain
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadDependencies(): void
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

    private function initHooks(): void
    {
    }
}