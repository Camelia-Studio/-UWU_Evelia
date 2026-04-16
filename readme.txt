=== Evelia ===
Contributors: cameliastudio
Donate link: https://fr.tipeee.com/asso-camelia
Tags: discord, events, calendar, shortcode, scheduled events
Requires at least: 5.2
Tested up to: 6.7
Stable tag: 1.0.9
Requires PHP: 8.0
License: MIT
License URI: https://opensource.org/license/mit

Affichez les événements planifiés de votre serveur Discord directement sur votre site WordPress grâce à un shortcode simple.

== Description ==

Evelia connecte votre serveur Discord à votre site WordPress pour afficher automatiquement vos événements planifiés. Grâce à l'API Discord, le plugin récupère et présente les événements sous forme de cartes visuelles personnalisables.

**Fonctionnalités principales :**

* Récupération automatique des événements via l'API Discord v10
* Affichage via le shortcode `[evelia_events]`
* Filtrage des événements par mot-clé dans leur description
* Mise en cache intelligente (12 heures) avec invalidation automatique lors du changement de configuration
* Deux mises en page au choix : horizontale (image à droite) et verticale (image en haut)
* Personnalisation complète des couleurs (fond, titres, boutons, dates, etc.)
* Textes entièrement configurables (titre du bloc, description, texte du bouton, message si aucun événement)
* Aperçu en direct des couleurs dans l'interface d'administration
* Bouton de vidage manuel du cache

**Utilisation du shortcode :**

Insérez `[evelia_events]` dans n'importe quelle page ou article WordPress pour afficher la liste des événements de votre serveur Discord.

== Installation ==

1. Téléversez le dossier `UWU_Evelia` dans le répertoire `/wp-content/plugins/`.
2. Activez le plugin depuis le menu **Extensions** de votre tableau de bord WordPress.
3. Rendez-vous dans **Réglages > Evelia** pour configurer le plugin.
4. Renseignez les informations requises :
   * **Token du bot Discord** — le token d'authentification de votre bot Discord.
   * **ID du serveur Discord** — l'identifiant numérique de votre serveur (Guild ID).
   * **URL d'invitation Discord** — le lien de base vers votre serveur (ex. `https://discord.gg/monserveur`).
5. (Optionnel) Saisissez un mot-clé dans le champ **Mot à rechercher** pour n'afficher que les événements dont la description contient ce mot.
6. Insérez le shortcode `[evelia_events]` dans la page de votre choix.

== Frequently Asked Questions ==

= Comment obtenir un token de bot Discord ? =

Rendez-vous sur le [Portail développeurs Discord](https://discord.com/developers/applications), créez une nouvelle application, puis dans l'onglet **Bot**, générez et copiez le token. Assurez-vous que votre bot est bien invité sur votre serveur avec les permissions nécessaires pour lire les événements planifiés (`MANAGE_EVENTS` ou `VIEW_GUILD_INSIGHTS`).

= Comment trouver l'ID de mon serveur Discord ? =

Activez le **Mode développeur** dans les paramètres Discord (Apparence > Mode développeur), puis faites un clic droit sur l'icône de votre serveur et sélectionnez **Copier l'identifiant**.

= Les événements ne s'affichent pas. Que faire ? =

Vérifiez que le token du bot et l'ID du serveur sont correctement renseignés. Si vous venez de modifier la configuration, videz le cache depuis l'onglet **Configuration** (bouton **Vider le cache**). Assurez-vous également que votre serveur Discord possède des événements planifiés actifs ou à venir.

= À quelle fréquence les événements sont-ils mis à jour ? =

Les événements sont mis en cache pendant 12 heures. Le cache est automatiquement invalidé lorsque vous modifiez le token, l'ID du serveur ou le mot-clé de filtrage. Vous pouvez également le vider manuellement depuis l'onglet **Configuration**.

= Puis-je afficher plusieurs blocs d'événements sur la même page ? =

Le shortcode `[evelia_events]` est conçu pour un affichage unique par page, reflétant la configuration globale du plugin.

= Comment personnaliser l'apparence des cartes ? =

Rendez-vous dans **Réglages > Evelia**, onglet **Personnalisation**. Vous pouvez modifier les couleurs de fond, des titres, des boutons et des dates, avec un aperçu en direct des modifications.

== Screenshots ==

1. Page de configuration — onglet Configuration (Discord).
2. Page de configuration — onglet Personnalisation avec aperçu en direct.
3. Page de configuration — onglet Mise en page.
4. Page de configuration — onglet Textes.
5. Affichage frontend — mise en page horizontale.
6. Affichage frontend — mise en page verticale.

== Changelog ==

= 1.0.9 =
* Amélioration de la logique d'invalidation du cache lors du changement de paramètres Discord.

= 1.0.8 =
* Ajout de la mise en page verticale pour les cartes d'événements.
* Aperçu en direct des couleurs dans l'interface d'administration.

= 1.0.0 =
* Première version stable du plugin.
* Récupération des événements Discord via l'API v10.
* Shortcode `[evelia_events]`.
* Mise en cache par transients (12 heures).
* Interface d'administration avec personnalisation des couleurs et des textes.

== Upgrade Notice ==

= 1.0.9 =
Mise à jour recommandée : amélioration de la gestion du cache. Le cache sera automatiquement invalidé lors du changement de configuration Discord.
