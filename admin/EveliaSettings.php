<?php
if (!defined('ABSPATH')) {
    exit;
}

class EveliaSettings {

    private array $colorsOptions;
    private array $discordOptions;
    private array $textOptions;

    public function __construct() {
        $this->initOptions();
    }

    /**
     * Initialise les options
     */
    private function initOptions(): void
    {
        $this->colorsOptions = [
            'block_background_color' => [
                'value' => get_option('block_background_color', 'transparent'),
                'label' => 'Couleur de fond du bloc d\'événements',
                'type' => 'color',
            ],
            'block_title_color' => [
                'value' => get_option('block_title_color', '#e63946'),
                'label' => 'Couleur du titre du bloc d\'événements',
                'type' => 'color',
            ],
            'block_description_color' => [
                'value' => get_option('block_description_color', '#d0d0d0'),
                'label' => 'Couleur de la description du bloc',
                'type' => 'color',
            ],
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

        $this->textOptions = [
            'evelia_block_title' => [
                'value' => get_option('evelia_block_title', ''),
                'label' => 'Titre du bloc d\'événements (optionnel)',
                'type' => 'text',
            ],
            'evelia_block_description' => [
                'value' => get_option('evelia_block_description', ''),
                'label' => 'Description du bloc d\'événements (optionnel)',
                'type' => 'textarea',
            ],
            'evelia_button_text' => [
                'value' => get_option('evelia_button_text', 'S\'inscrire !'),
                'label' => 'Texte du bouton d\'inscription',
                'type' => 'text',
            ],
            'evelia_no_events_text' => [
                'value' => get_option('evelia_no_events_text', 'Aucun évènement trouvé.'),
                'label' => 'Message quand aucun évènement n\'est trouvé',
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

        // Mettre à jour les options de textes
        foreach ($this->textOptions as $optionName => $optionData) {
            if (isset($_POST[$optionName])) {
                $newValue = sanitize_text_field($_POST[$optionName]);
                update_option($optionName, $newValue);
                $this->textOptions[$optionName]['value'] = $newValue;
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
        $activeTab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'configuration';
        ?>
        <div class="wrap">
            <h1>Configuration du plugin Evelia</h1>

            <?php $this->renderTabs($activeTab); ?>

            <style>
                .nav-tab-wrapper {
                    margin-bottom: 20px;
                }
            </style>

            <form method="post" action="">
                <?php
                switch ($activeTab) {
                    case 'personnalisation':
                        $this->renderColorsSection();
                        break;
                    case 'textes':
                        $this->renderTextsSection();
                        break;
                    case 'configuration':
                    default:
                        $this->renderDiscordSection();
                        break;
                }
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Affiche les onglets de navigation
     */
    private function renderTabs(string $activeTab): void
    {
        $tabs = [
            'configuration' => 'Configuration',
            'textes' => 'Textes',
            'personnalisation' => 'Personnalisation',
        ];
        ?>
        <nav class="nav-tab-wrapper">
            <?php foreach ($tabs as $tabKey => $tabLabel): ?>
                <a href="<?php echo esc_url(add_query_arg('tab', $tabKey)); ?>"
                   class="nav-tab <?php echo $activeTab === $tabKey ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html($tabLabel); ?>
                </a>
            <?php endforeach; ?>
        </nav>
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

    /**
     * Section textes
     */
    private function renderTextsSection(): void
    {
        ?>
        <h2 class="title">Gestion des textes</h2>
        <table class="form-table">
            <tbody>
            <?php foreach ($this->textOptions as $optionName => $optionData): ?>
                <tr>
                    <th>
                        <label for="<?php echo esc_attr($optionName); ?>">
                            <?php echo esc_html($optionData['label']); ?>
                        </label>
                    </th>
                    <td>
                        <?php if ($optionData['type'] === 'textarea'): ?>
                            <textarea id="<?php echo esc_attr($optionName); ?>"
                                      name="<?php echo esc_attr($optionName); ?>"
                                      rows="4"
                                      class="large-text"><?php echo esc_textarea($optionData['value']); ?></textarea>
                        <?php else: ?>
                            <input type="<?php echo esc_attr($optionData['type']); ?>"
                                   id="<?php echo esc_attr($optionName); ?>"
                                   name="<?php echo esc_attr($optionName); ?>"
                                   value="<?php echo esc_attr($optionData['value']); ?>"
                                   class="regular-text"/>
                        <?php endif; ?>
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