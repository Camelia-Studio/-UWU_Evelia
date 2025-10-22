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
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'));
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
     * Charge les assets admin
     */
    public function enqueueAdminAssets(string $hook): void
    {
        // Charger uniquement sur la page des paramètres Evelia
        if ('settings_page_evelia-settings' !== $hook) {
            return;
        }

        // Charger le CSS du calendrier pour l'aperçu
        wp_enqueue_style(
            'evelia-calendar-preview',
            EVELIA_PLUGIN_URL . 'assets/css/calendar.css',
            array(),
            EVELIA_VERSION
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