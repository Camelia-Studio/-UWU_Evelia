<?php

/*
 * Plugin Name:       Camélia Studio
 * Plugin URI:        https://camelia-studio.org
 * Description:       Plugin to manage some features of Camélia Studio.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Camélia Studio
 * Author URI:        https://camelia-studio.org
 * License:          MIT
 * License URI:       https://opensource.org/license/mit
 * Text Domain:       camelia-studio
 */

// On ajoute un shortcode pour afficher la liste des évènements

function camelianime_events_shortcode(): string {
	$discordBase = 'https://discord.gg/nBuZ9vJ';
	// On récupère les évènements depuis l'API
	$response = wp_remote_get( 'https://git.crystalyx.net/camelia-studio/Camelia-Studio-WP/raw/branch/master/sample.json', [
		'timeout' => 10,
	] );

	if ( is_wp_error( $response ) ) {
		return '<p>Erreur lors de la récupération des évènements.</p>';
	}

	$events = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( empty( $events ) ) {
		return '<p>Aucun évènement trouvé.</p>';
	}

	// On construit le HTML pour afficher les évènements
	$html = '<div class="ca-calendar-container">';
	foreach ( $events as $event ) {
		$formattedDate = date( 'd/m/Y - H:i', strtotime( $event['scheduled_start_time'] ) );
		$html          .= <<<EOD
<div class="ca-event-card">
	<div class="ca-event-details">
		<div class="ca-event-date">
			<i class="fas fa-calendar-alt"></i> {$formattedDate}
		</div>
		<div class="ca-event-title">
			{$event['name']}
		</div>
		<div class="ca-event-actions">
			<a href="{$discordBase}?event={$event['id']}" class="ca-btn" target="_blank"><i class="fas fa-sign-in-alt"></i> S'inscrire !</a>
		</div>
	</div>
EOD;
		if ( ! empty( $event['image'] ) ) {
			$html          .= <<<EOD
		<img src="{$event['image']}" alt="{$event['name']}" class="ca-event-image" />
EOD;

		}
		$html .= '</div>';
	}
	$html .= '</div>';

	return $html;
}

function loadAssets(): void
{
	wp_enqueue_style(
		'camelianime-events-style',
		plugin_dir_url( __FILE__ ) . 'assets/css/calendar.css'
	);
}

add_action( 'wp_enqueue_scripts', 'loadAssets' );
add_shortcode( 'camelianime_events', 'camelianime_events_shortcode' );

function cameliastudio_administration_add_admin_page() {
    add_submenu_page(
        'options-general.php',
        'Options de Camélia Studio',
        'Camélia Studio',
        'manage_options',
        'administration',
        'administration_page'
    );
}

function administration_page() {
    $options = [
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


    if (isset($_POST['submit'])) {
        // On met à jour les options
        foreach ($options as $option_name => $option_data) {
            if (isset($_POST[$option_name])) {
                update_option($option_name, sanitize_text_field($_POST[$option_name]));
                $options[$option_name]['value'] = sanitize_text_field($_POST[$option_name]);
            }
        }
        echo '<div class="updated"><p>Options enregistrées avec succès !</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Configuration du plugin Camélia Studio</h1>
        <h2 class="title">Gestion des couleurs</h2>
        <form method="post" action="">
            <table class="form-table">
                <tbody>
                <?php
                foreach ($options as $option_name => $option_data) {
                    ?>
                    <tr>
                        <th>
                            <label for="<?php echo esc_attr($option_name); ?>"><?php echo esc_html($option_data['label']); ?></label>
                        </th>
                        <td>
                            <input type="<?php echo esc_attr($option_data['type']); ?>"
                                   id="<?php echo esc_attr($option_name); ?>"
                                   name="<?php echo esc_attr($option_name); ?>"
                                   value="<?php echo esc_attr($option_data['value']); ?>"
                                   class="regular-text" />
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" name="submit" class="button button-primary" value="Enregistrer" />
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>
    <?php
}

function add_colors_to_website() {
    $caEventTitleColor = get_option('ca_event_title_color', '#e63946');
    $btnBackground = get_option('btn_background', '#e63946');
    $cardBackgroundColor = get_option('card_background_color', '#2c2f33');
    $buttonForeground = get_option('button_foreground', '#23272a');
    $btnBackgroundHover = get_option('btn_background_hover', '#FFD55F');
    $btnForegroundHover = get_option('btn_foreground_hover', '#23272a');
    $eventDateColor = get_option('event_date_color', '#d0d0d0');
    ?>
    <style>
        :root {
            --ca-event-title-color:  <?php echo esc_attr($caEventTitleColor); ?>;
            --card-background-color: <?php echo esc_attr($cardBackgroundColor); ?>;
            --button-foreground:  <?php echo esc_attr($buttonForeground); ?>;
            --btn-background: <?php echo esc_attr($btnBackground); ?>;
            --btn-background-hover: <?php echo esc_attr($btnBackgroundHover); ?>;
            --btn-foreground-hover: <?php echo esc_attr($btnForegroundHover); ?>;
            --event-date-color: <?php echo esc_attr($eventDateColor); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'add_colors_to_website');

add_action('admin_menu', 'cameliastudio_administration_add_admin_page');