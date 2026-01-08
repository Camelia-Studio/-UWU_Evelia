<?php
if (!defined('ABSPATH')) {
    exit;
}

class EveliaDiscordApi
{
    private static $instance = null;

    public static function getInstance(): ?EveliaDiscordApi
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Normalise une chaîne en supprimant les accents et en convertissant en minuscules
     */
    private function normalizeString(string $text): string
    {
        // Convertir en minuscules
        $text = mb_strtolower($text, 'UTF-8');

        // Supprimer les accents
        $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

        return $text;
    }

    /**
     * Génère la clé de cache
     */
    private function getCacheKey(): string
    {
        $discordGuildId = get_option('discord_guild_id', '');
        $wordToSearch = get_option('discord_word_to_search', '');
        return 'evelia_events_cache_' . md5($discordGuildId . $wordToSearch);
    }

    /**
     * Invalide le cache des événements
     */
    public function invalidateCache(): void
    {
        $cache_key = $this->getCacheKey();
        delete_transient($cache_key);
    }

    /**
     * Vérifie si les paramètres ont changé et invalide le cache si nécessaire
     */
    private function checkAndInvalidateCacheIfNeeded(): void
    {
        // Récupérer les paramètres actuels
        $currentParams = [
            'guild_id' => get_option('discord_guild_id', ''),
            'word_to_search' => get_option('discord_word_to_search', ''),
            'bot_token' => get_option('discord_bot_token', '')
        ];

        // Récupérer les paramètres stockés pour la dernière génération de cache
        $last_params = get_option('evelia_last_cache_params', []);

        // Comparer les paramètres
        if ($last_params !== $currentParams) {
            // Les paramètres ont changé, invalider le cache
            $this->invalidateCache();
            
            // Mettre à jour les paramètres stockés
            update_option('evelia_last_cache_params', $currentParams);
        }
    }

    /**
     * Récupère les événements depuis l'API Discord
     */
    public function getEventsFromDiscord(bool $forceRefresh = false): array
    {
        $discordBotToken = get_option('discord_bot_token', '');
        $discordGuildId = get_option('discord_guild_id', '');
        $wordToSearch = get_option('discord_word_to_search', '');

        if ('' === $discordBotToken || '' === $discordGuildId) {
            return [];
        }

        $cache_key = $this->getCacheKey();
        $cache_duration = 12 * HOUR_IN_SECONDS; // 12 heures

        // Vérifier si les paramètres ont changé
        $this->checkAndInvalidateCacheIfNeeded();

        // Forcer le rafraîchissement si demandé
        if ($forceRefresh) {
            $this->invalidateCache();
        }

        // Vérifier si les données sont en cache
        $cached_data = get_transient($cache_key);
        if ($cached_data !== false) {
            return $cached_data;
        }

        // Récupérer les événements depuis l'API
        $response = wp_remote_get("https://discord.com/api/v10/guilds/" . $discordGuildId . "/scheduled-events?with_user_count=true", [
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bot ' . $discordBotToken,
            ],
        ]);

        if (is_wp_error($response)) {
            return [];
        }

        $events = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($events['message'])) {
            return [];
        }

        // Filtrer les événements qui contiennent le mot-clé (insensible à la casse et aux accents)
        if ('' !== $wordToSearch) {
            $normalizedKeyword = $this->normalizeString($wordToSearch);
            $events = array_filter($events, function ($event) use ($normalizedKeyword) {
                if (!isset($event['description'])) {
                    return false;
                }
                $normalizedDescription = $this->normalizeString($event['description']);
                return strpos($normalizedDescription, $normalizedKeyword) !== false;
            });
        }

        set_transient($cache_key, $events, $cache_duration);
        return $events;
    }
}