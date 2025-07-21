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

        if ('' === $discordBase) {
            return '<p>Aucun évènement trouvé.</p>';
        }

        $discord_api = EveliaDiscordApi::getInstance();
        $events = $discord_api->getEventsFromDiscord();

        if (sizeof($events) == 0) {
            return '<p>Aucun évènement trouvé.</p>';
        }

        return $this->renderEventsHtml($events, $discordBase);
    }

    /**
     * Génère le HTML des événements
     * @throws Exception
     */
    private function renderEventsHtml(array $events, string $discordBase): string
    {
        $html = '<div class="ca-calendar-container">';

        foreach ($events as $event) {
            $date = new DateTime($event['scheduled_start_time']);
            $date->setTimezone(new DateTimeZone('Europe/Paris'));
            $formattedDate = $date->format('d/m/Y H:i');

            $html .= $this->render_single_event($event, $formattedDate, $discordBase);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Génère le HTML d'un événement
     */
    private function render_single_event(array $event, string $formattedDate, string $discordBase): string
    {
        $html = <<<EOD
<div class="ca-event-card">
    <div class="ca-event-details">
        <div class="ca-event-date">
            <i class="fas fa-calendar-alt"></i> {$formattedDate}
        </div>
        <div class="ca-event-title">
            {$event['name']}
        </div>
        <div class="ca-event-actions">
            <a href="$discordBase?event={$event['id']}" class="ca-btn" target="_blank">
                <i class="fas fa-sign-in-alt"></i> S'inscrire !
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