<?php
if (!defined('ABSPATH')) {
    exit;
}

class EveliaSettings {

    private array $colorsOptions;
    private array $discordOptions;

    public function __construct() {
        $this->initOptions();
    }

    /**
     * Initialise les options
     */
    private function initOptions(): void
    {
        $this->colorsOptions = [
            'ca_event_title_color' => [
                'value' => get_option('ca_event_title_color', '#e63946'),
                'label' => 'Couleur du titre des évènements',
                'type' => 'color',
            ],
            'card_background_color' => [
                'value' => get_option('card_background_color', '#2c2f33'),
                'label' => 'Couleur de fond des cartes',
                'type' => 'color',
            ],
            'btn_background' => [
                'value' => get_option('btn_background', '#e63946'),
                'label' => 'Couleur de fond des boutons',
                'type' => 'color',
            ],
            'button_foreground' => [
                'value' => get_option('button_foreground', '#23272a'),
                'label' => 'Couleur du texte des boutons',
                'type' => 'color',
            ],
            'btn_background_hover' => [
                'value' => get_option('btn_background_hover', '#FFD55F'),
                'label' => 'Couleur de fond des boutons au survol',
                'type' => 'color',
            ],
            'btn_foreground_hover' => [
                'value' => get_option('btn_foreground_hover', '#23272a'),
                'label' => 'Couleur du texte des boutons au survol',
                'type' => 'color',
            ],
            'event_date_color' => [
                'value' => get_option('event_date_color', '#d0d0d0'),
                'label' => 'Couleur de la date des évènements',
                'type' => 'color',
            ],
        ];

        $this->discordOptions = [
            'discord_bot_token' => [
                'value' => get_option('discord_bot_token', ''),
                'label' => 'Token du bot Discord',
                'type' => 'text',
            ],
            'discord_invite_url' => [
                'value' => get_option('discord_invite_url', ''),
                'label' => 'URL d\'invitation Discord',
                'type' => 'url',
            ],
            'discord_guild_id' => [
                'value' => get_option('discord_guild_id', ''),
                'label' => 'ID du serveur Discord',
                'type' => 'text',
            ],
            'discord_word_to_search' => [
                'value' => get_option('discord_word_to_search', ''),
                'label' => 'Mot à rechercher dans la description des évènements (laisser vide pour tous les évènements)',
                'type' => 'text',
            ],
        ];
    }

    /**
     * Traite la soumission du formulaire
     */
    private function processFormSubmission(): void
    {
        if (!isset($_POST['submit'])) {
            return;
        }

        // Mettre à jour les options de couleur
        foreach ($this->colorsOptions as $optionName => $optionData) {
            if (isset($_POST[$optionName])) {
                $newValue = sanitize_text_field($_POST[$optionName]);
                update_option($optionName, $newValue);
                $this->colorsOptions[$optionName]['value'] = $newValue;
            }
        }

        // Mettre à jour les options Discord
        foreach ($this->discordOptions as $optionName => $optionData) {
            if (isset($_POST[$optionName])) {
                $newValue = sanitize_text_field($_POST[$optionName]);
                update_option($optionName, $newValue);
                $this->discordOptions[$optionName]['value'] = $newValue;
            }
        }

        echo '<div class="updated"><p>Options enregistrées avec succès !</p></div>';
    }

    /**
     * Affiche la page de configuration
     */
    public function renderPage(): void
    {
        $this->processFormSubmission();
        ?>
        <div class="wrap">
            <h1>Configuration du plugin Evelia</h1>
            <form method="post" action="">
                <?php $this->renderDiscordSection(); ?>
                <?php $this->renderColorsSection(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Section Discord
     */
    private function renderDiscordSection(): void
    {
        ?>
        <h2 class="title">Gestion des informations Discord</h2>
        <table class="form-table">
            <tbody>
            <?php foreach ($this->discordOptions as $optionName => $optionData): ?>
                <tr>
                    <th>
                        <label for="<?php echo esc_attr($optionName); ?>">
                            <?php echo esc_html($optionData['label']); ?>
                        </label>
                    </th>
                    <td>
                        <input type="<?php echo esc_attr($optionData['type']); ?>"
                               id="<?php echo esc_attr($optionName); ?>"
                               name="<?php echo esc_attr($optionName); ?>"
                               value="<?php echo esc_attr($optionData['value']); ?>"
                               class="regular-text"/>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Section couleurs
     */
    private function renderColorsSection(): void
    {
        ?>
        <h2 class="title">Gestion des couleurs</h2>
        <table class="form-table">
            <tbody>
            <?php foreach ($this->colorsOptions as $optionName => $optionData): ?>
                <tr>
                    <th>
                        <label for="<?php echo esc_attr($optionName); ?>">
                            <?php echo esc_html($optionData['label']); ?>
                        </label>
                    </th>
                    <td>
                        <input type="<?php echo esc_attr($optionData['type']); ?>"
                               id="<?php echo esc_attr($optionName); ?>"
                               name="<?php echo esc_attr($optionName); ?>"
                               value="<?php echo esc_attr($optionData['value']); ?>"
                               class="regular-text"/>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button button-primary" value="Enregistrer"/>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
    }
}