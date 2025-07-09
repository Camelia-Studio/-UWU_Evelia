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
			<a href="{$discordBase}?event={$event['id']}" class="ca-btn" target="_blank"><i class="fas fa-sign-in-alt"></i> S'inscrire à la séance</a>
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