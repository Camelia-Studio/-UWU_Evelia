<?php
if (!defined('ABSPATH')) {
    exit;
}

class EveliaSettings {

    private array $colorsOptions;
    private array $discordOptions;
    private array $textOptions;
    private array $layoutOptions;

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

        $this->layoutOptions = [
            'evelia_card_layout' => [
                'value' => get_option('evelia_card_layout', 'horizontal'),
                'label' => 'Mise en page des cartes d\'événements',
                'type' => 'radio',
                'options' => [
                    'horizontal' => 'Horizontale (image à droite)',
                    'vertical' => 'Verticale (image en haut)',
                ],
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

        // Mettre à jour les options de mise en page
        foreach ($this->layoutOptions as $optionName => $optionData) {
            if (isset($_POST[$optionName])) {
                $newValue = sanitize_text_field($_POST[$optionName]);
                update_option($optionName, $newValue);
                $this->layoutOptions[$optionName]['value'] = $newValue;
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
                    case 'mise-en-page':
                        $this->renderLayoutSection();
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
            'mise-en-page' => 'Mise en page',
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
        $currentLayout = get_option('evelia_card_layout', 'horizontal');
        $layoutClass = $currentLayout === 'vertical' ? 'vertical' : '';
        $containerClass = $currentLayout === 'vertical' ? 'ca-calendar-container has-vertical-layout' : 'ca-calendar-container';
        ?>
        <h2 class="title">Gestion des couleurs</h2>
        <p>Modifiez les couleurs et visualisez le résultat en temps réel à droite.</p>

        <style>
            .evelia-color-layout {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                margin: 2rem 0;
            }
            .evelia-color-options {
                min-width: 0;
            }
            .color-preview-section {
                background: #f5f5f5;
                padding: 2rem;
                border-radius: 8px;
                position: sticky;
                top: 32px;
                height: fit-content;
            }
            .color-preview-section h3 {
                margin-top: 0;
                margin-bottom: 1rem;
            }
            #evelia-preview-container {
                max-width: 100%;
            }
            #evelia-preview-container .ca-calendar-container {
                max-width: 100%;
                margin: 0 auto;
            }
            #evelia-preview-container .ca-calendar-container.has-vertical-layout {
                max-width: 100%;
            }
            #evelia-preview-container .ca-event-card {
                margin: 0 auto;
            }
            #evelia-preview-container .ca-event-card:not(.vertical) {
                max-width: 100%;
            }
            @media (max-width: 1200px) {
                .evelia-color-layout {
                    grid-template-columns: 1fr;
                }
                .color-preview-section {
                    position: static;
                }
            }
        </style>

        <div class="evelia-color-layout">
            <div class="evelia-color-options">
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
                                       class="regular-text color-input"
                                       data-css-var="--<?php echo esc_attr(str_replace('_', '-', $optionName)); ?>"/>
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
            </div>

            <div class="color-preview-section">
                <h3>Aperçu en direct</h3>
                <div id="evelia-preview-container" style="
                --block-background-color: <?php echo esc_attr(get_option('block_background_color', 'transparent')); ?>;
                --block-title-color: <?php echo esc_attr(get_option('block_title_color', '#e63946')); ?>;
                --block-description-color: <?php echo esc_attr(get_option('block_description_color', '#d0d0d0')); ?>;
                --ca-event-title-color: <?php echo esc_attr(get_option('ca_event_title_color', '#e63946')); ?>;
                --card-background-color: <?php echo esc_attr(get_option('card_background_color', '#2c2f33')); ?>;
                --button-foreground: <?php echo esc_attr(get_option('button_foreground', '#23272a')); ?>;
                --btn-background: <?php echo esc_attr(get_option('btn_background', '#e63946')); ?>;
                --btn-background-hover: <?php echo esc_attr(get_option('btn_background_hover', '#FFD55F')); ?>;
                --btn-foreground-hover: <?php echo esc_attr(get_option('btn_foreground_hover', '#23272a')); ?>;
                --event-date-color: <?php echo esc_attr(get_option('event_date_color', '#d0d0d0')); ?>;
            ">
                <div class="<?php echo esc_attr($containerClass); ?>" id="preview-calendar">
                    <h2 class="ca-calendar-title">Titre du bloc d'événements</h2>
                    <p class="ca-calendar-description">Description du bloc d'événements</p>
                    <div class="ca-event-card <?php echo esc_attr($layoutClass); ?>">
                        <div class="ca-event-details">
                            <div class="ca-event-date">
                                <i class="fas fa-calendar-alt"></i> 25/12/2024 20:00
                            </div>
                            <div class="ca-event-title">
                                Exemple d'événement
                            </div>
                            <div class="ca-event-actions">
                                <a href="#" class="ca-btn" onclick="return false;">
                                    <i class="fas fa-sign-in-alt"></i> S'inscrire !
                                </a>
                            </div>
                        </div>
                        <img src="https://camelia-studio.org/wp-content/uploads/2025/07/1080JPEG.jpg"
                             alt="Exemple"
                             class="ca-event-image" />
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const colorInputs = document.querySelectorAll('.color-input');
                const previewContainer = document.getElementById('evelia-preview-container');

                colorInputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        const cssVar = this.getAttribute('data-css-var');
                        const value = this.value;
                        previewContainer.style.setProperty(cssVar, value);
                    });
                });
            });
        </script>
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

    /**
     * Section mise en page
     */
    private function renderLayoutSection(): void
    {
        $currentLayout = get_option('evelia_card_layout', 'horizontal');
        ?>
        <h2 class="title">Mise en page des cartes d'événements</h2>
        <p>Choisissez la disposition des cartes d'événements sur votre site.</p>

        <style>
            .layout-options {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                margin: 2rem 0;
            }
            .layout-option {
                border: 3px solid #ddd;
                border-radius: 8px;
                padding: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .layout-option:hover {
                border-color: #2271b1;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .layout-option.selected {
                border-color: #2271b1;
                background-color: #f0f6fc;
            }
            .layout-option input[type="radio"] {
                margin-right: 0.5rem;
            }
            .layout-option label {
                display: flex;
                align-items: center;
                font-weight: 600;
                font-size: 16px;
                margin-bottom: 1rem;
                cursor: pointer;
            }
            .layout-preview {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 1rem;
                margin-top: 1rem;
            }
            .preview-card-horizontal {
                display: grid;
                grid-template-columns: 1fr 120px;
                gap: 1rem;
                background: #2c2f33;
                border-radius: 8px;
                padding: 1rem;
                color: #fff;
            }
            .preview-card-vertical {
                display: flex;
                flex-direction: column;
                background: #2c2f33;
                border-radius: 8px;
                overflow: hidden;
                color: #fff;
                max-width: 300px;
                margin: 0 auto;
            }
            .preview-image-horizontal {
                width: 120px;
                height: 80px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 4px;
            }
            .preview-image-vertical {
                width: 100%;
                height: 150px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .preview-content {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            .preview-content-vertical {
                padding: 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            .preview-date {
                font-size: 12px;
                color: #d0d0d0;
            }
            .preview-title {
                font-weight: 600;
                color: #e63946;
            }
            .preview-button {
                background: #e63946;
                color: #fff;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                border: none;
                font-size: 12px;
                margin-top: 0.5rem;
                display: inline-block;
                width: fit-content;
            }
        </style>

        <div class="layout-options">
            <div class="layout-option <?php echo $currentLayout === 'horizontal' ? 'selected' : ''; ?>"
                 onclick="document.getElementById('layout-horizontal').checked = true; this.parentElement.querySelectorAll('.layout-option').forEach(el => el.classList.remove('selected')); this.classList.add('selected');">
                <label for="layout-horizontal">
                    <input type="radio"
                           id="layout-horizontal"
                           name="evelia_card_layout"
                           value="horizontal"
                           <?php checked($currentLayout, 'horizontal'); ?>>
                    Mise en page horizontale
                </label>
                <p class="description">Image à droite, informations à gauche (mise en page actuelle)</p>
                <div class="layout-preview">
                    <div class="preview-card-horizontal">
                        <div class="preview-content">
                            <div class="preview-date">📅 25/12/2024 20:00</div>
                            <div class="preview-title">Titre de l'événement</div>
                            <button class="preview-button">S'inscrire !</button>
                        </div>
                        <div class="preview-image-horizontal"></div>
                    </div>
                </div>
            </div>

            <div class="layout-option <?php echo $currentLayout === 'vertical' ? 'selected' : ''; ?>"
                 onclick="document.getElementById('layout-vertical').checked = true; this.parentElement.querySelectorAll('.layout-option').forEach(el => el.classList.remove('selected')); this.classList.add('selected');">
                <label for="layout-vertical">
                    <input type="radio"
                           id="layout-vertical"
                           name="evelia_card_layout"
                           value="vertical"
                           <?php checked($currentLayout, 'vertical'); ?>>
                    Mise en page verticale
                </label>
                <p class="description">Image en haut, informations en dessous (format plus carré)</p>
                <div class="layout-preview">
                    <div class="preview-card-vertical">
                        <div class="preview-image-vertical"></div>
                        <div class="preview-content-vertical">
                            <div class="preview-date">📅 25/12/2024 20:00</div>
                            <div class="preview-title">Titre de l'événement</div>
                            <button class="preview-button">S'inscrire !</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="form-table">
            <tbody>
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