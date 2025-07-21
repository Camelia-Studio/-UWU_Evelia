<?php

if (!defined('ABSPATH')) {
    exit;
}

class EveliaAssets
{
    private static $instance = null;

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueFrontendAssets'));
        add_action('wp_head', array($this, 'addCustomCssVariables'));
    }

    public static function getInstance(): ?EveliaAssets
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Charge les assets frontend
     */
    public function enqueueFrontendAssets()
    {
        wp_enqueue_style(
            'eveliaCalendarStyle',
            EVELIA_PLUGIN_URL . 'assets/css/calendar.css',
            array(),
            EVELIA_VERSION
        );
    }

    /**
     * Ajoute les variables CSS personnalisées
     */
    public function addCustomCssVariables()
    {
        $cssVars = $this->getCssVariables();

        echo '<style>:root {';
        foreach ($cssVars as $property => $value) {
            echo esc_attr($property) . ': ' . esc_attr($value) . ';';
        }
        echo '}</style>';
    }

    /**
     * Récupère les variables CSS depuis les options
     */
    private function getCssVariables(): array
    {
        return [
            '--ca-event-title-color' => get_option('ca_event_title_color', '#e63946'),
            '--card-background-color' => get_option('card_background_color', '#2c2f33'),
            '--button-foreground' => get_option('button_foreground', '#23272a'),
            '--btn-background' => get_option('btn_background', '#e63946'),
            '--btn-background-hover' => get_option('btn_background_hover', '#FFD55F'),
            '--btn-foreground-hover' => get_option('btn_foreground_hover', '#23272a'),
            '--event-date-color' => get_option('event_date_color', '#d0d0d0'),
        ];
    }
}