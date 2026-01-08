<?php
if (!defined('ABSPATH')) {
    exit;
}

class EveliaFrontend
{

    private static $instance = null;

    private function __construct()
    {
        add_shortcode('evelia_events', array($this, 'eventsShortcode'));
    }

    public static function getInstance(): ?EveliaFrontend
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Shortcode pour afficher les événements
     * @throws Exception
     */
    public function eventsShortcode(): string
    {
        $discordBase = get_option('discord_invite_url', '');
        $noEventsText = get_option('evelia_no_events_text', 'Aucun évènement trouvé.');
        $blockTitle = get_option('evelia_block_title', '');
        $blockDescription = get_option('evelia_block_description', '');

        if ('' === $discordBase) {
            return '<p>' . esc_html($noEventsText) . '</p>';
        }

        $discord_api = EveliaDiscordApi::getInstance();
        $events = $discord_api->getEventsFromDiscord(false);

        if (sizeof($events) == 0) {
            $finalText = '<div>';
            
            // Afficher le titre si présent
            if (!empty($blockTitle)) {
                $finalText .= '<h2 class="ca-calendar-title">' . esc_html($blockTitle) . '</h2>';
            }

            // Afficher la description si présente
            if (!empty($blockDescription)) {
                $finalText .= '<p class="ca-calendar-description">' . esc_html($blockDescription) . '</p>';
            }
            $finalText .= '<p>' . esc_html($noEventsText) . '</p>';
            $finalText .= '</div>';

            return $finalText;
        }

        return $this->renderEventsHtml($events, $discordBase);
    }

    /**
     * Génère le HTML des événements
     * @throws Exception
     */
    private function renderEventsHtml(array $events, string $discordBase): string
    {
        $buttonText = get_option('evelia_button_text', 'S\'inscrire !');
        $blockTitle = get_option('evelia_block_title', '');
        $blockDescription = get_option('evelia_block_description', '');
        $cardLayout = get_option('evelia_card_layout', 'horizontal');

        $containerClass = $cardLayout === 'vertical' ? 'ca-calendar-container has-vertical-layout' : 'ca-calendar-container';
        $html = '<div class="' . esc_attr($containerClass) . '">';

        // Afficher le titre si présent
        if (!empty($blockTitle)) {
            $html .= '<h2 class="ca-calendar-title">' . esc_html($blockTitle) . '</h2>';
        }

        // Afficher la description si présente
        if (!empty($blockDescription)) {
            $html .= '<p class="ca-calendar-description">' . esc_html($blockDescription) . '</p>';
        }

        foreach ($events as $event) {
            $date = new DateTime($event['scheduled_start_time']);
            $date->setTimezone(new DateTimeZone('Europe/Paris'));
            $formattedDate = $date->format('d/m/Y H:i');

            $html .= $this->render_single_event($event, $formattedDate, $discordBase, $buttonText, $cardLayout);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Génère le HTML d'un événement
     */
    private function render_single_event(array $event, string $formattedDate, string $discordBase, string $buttonText, string $cardLayout): string
    {
        $escapedButtonText = esc_html($buttonText);
        $layoutClass = $cardLayout === 'vertical' ? ' vertical' : '';
        $html = <<<EOD
<div class="ca-event-card{$layoutClass}">
    <div class="ca-event-details">
        <div class="ca-event-date">
            <i class="fas fa-calendar-alt"></i> {$formattedDate}
        </div>
        <div class="ca-event-title">
            {$event['name']}
        </div>
        <div class="ca-event-actions">
            <a href="$discordBase?event={$event['id']}" class="ca-btn" target="_blank">
                <i class="fas fa-sign-in-alt"></i> {$escapedButtonText}
            </a>
        </div>
    </div>
EOD;

        if (!empty($event['image'])) {
            $html .= <<<EOD
    <img src="https://cdn.discordapp.com/guild-events/{$event['id']}/{$event['image']}.png?size=256" alt="{$event['name']}" class="ca-event-image" />
EOD;
        }

        $html .= '</div>';
        return $html;
    }
}