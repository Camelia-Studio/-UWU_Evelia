<?php

if (!defined('ABSPATH')) {
    exit;
}

class EveliaAdmin
{

    private static ?EveliaAdmin $instance = null;

    private function __construct()
    {
        add_action('admin_menu', array($this, 'addAdminMenu'));
    }

    public static function getInstance(): ?EveliaAdmin
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Ajoute le menu d'administration
     */
    public function addAdminMenu(): void
    {
        add_submenu_page(
            'options-general.php',
            'Options de Evelia',
            'Evelia',
            'manage_options',
            'evelia-settings',
            array($this, 'settingsPage')
        );
    }

    /**
     * Page de configuration
     */
    public function settingsPage(): void
    {
        require_once EVELIA_PLUGIN_DIR . 'admin/EveliaSettings.php';
        $settings = new EveliaSettings();
        $settings->renderPage();
    }
}