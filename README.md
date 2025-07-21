# UWU Évélia

Un plugin WordPress pour afficher et gérer les événements Discord directement sur votre site web Wordpress.

## Description

Le plugin Évélia permet d'intégrer facilement les événements programmés de votre serveur Discord sur votre site WordPress. Il récupère automatiquement les événements via l'API Discord et les affiche avec un design personnalisable.

## Fonctionnalités

- 📅 Affichage automatique des événements Discord programmés
- 🎨 Interface d'administration pour personnaliser les couleurs
- 🔍 Filtrage des événements par mot-clé dans la description
- ⚡ Système de cache intégré (12 heures) pour optimiser les performances
- 🖼️ Support des images d'événements Discord
- 📱 Design responsive et moderne
- 🔗 Liens directs vers les événements Discord pour l'inscription

## Prérequis

- WordPress 5.2 ou supérieur
- PHP 8.0 ou supérieur
- Un bot Discord avec les permissions appropriées
- Accès à un serveur Discord avec des événements programmés

## Installation

1. Téléchargez le plugin et téléversez-le depuis la page "Extensions" de WordPress
2. Activez le plugin via le menu "Plugins" de WordPress
3. Configurez le plugin via "Réglages" > "Évélia"

## Configuration

### 1. Configuration Discord

Rendez-vous dans **Réglages > Évélia** et configurez :

- **Token du bot Discord** : Le token de votre bot Discord
- **URL d'invitation Discord** : L'URL d'invitation de votre serveur Discord
- **ID du serveur Discord** : L'identifiant numérique de votre serveur
- **Mot à rechercher** : (optionnel) Filtrer les événements contenant ce mot-clé
- **Couleurs** : (optionnel) Personnalisez les couleurs des éléments d'affichage

### 2. Personnalisation des couleurs

Le plugin permet de personnaliser :

- Couleur du titre des événements
- Couleur de fond des cartes
- Couleur de fond des boutons
- Couleur du texte des boutons
- Couleurs de survol des boutons
- Couleur de la date des événements

## Utilisation

### Shortcode

Utilisez le shortcode suivant pour afficher les événements sur vos pages ou articles :

```
[evelia_events]
```

### Exemple d'affichage

Le plugin génère automatiquement des cartes d'événements contenant :

- Date et heure de l'événement (format français)
- Titre de l'événement
- Image de l'événement (si disponible)
- Bouton d'inscription avec lien direct vers Discord

## Structure des fichiers

```
evelia/
├── Evelia.php          # Fichier principal du plugin
├── assets/
│   └── css/
│       └── calendar.css       # Styles pour l'affichage des événements
└── README.md                  # Ce fichier
```

## Configuration du bot Discord

Pour utiliser ce plugin, vous devez :

1. Créer un bot Discord sur le [Discord Developer Portal](https://discord.com/developers/applications)
2. Récupérer le token du bot
3. Inviter le bot sur votre serveur avec les permissions :
    - `View Channels`
    - `Read Message History`
4. Récupérer l'ID de votre serveur Discord

## API utilisée

Le plugin utilise l'API Discord v10 :
- Endpoint : `https://discord.com/api/v10/guilds/{guild_id}/scheduled-events`
- Authentification : Bot Token
- Paramètres : `with_user_count=true`

## Cache et performances

- **Durée du cache** : 12 heures
- **Clé de cache** : Basée sur l'ID du serveur et le mot-clé de recherche
- **Timeout API** : 10 secondes

## Variables CSS personnalisables

Le plugin génère automatiquement les variables CSS suivantes :

```css
:root {
    --ca-event-title-color: #e63946;
    --card-background-color: #2c2f33;
    --button-foreground: #23272a;
    --btn-background: #e63946;
    --btn-background-hover: #FFD55F;
    --btn-foreground-hover: #23272a;
    --event-date-color: #d0d0d0;
}
```

## Classes CSS disponibles

- `.ca-calendar-container` : Conteneur principal
- `.ca-event-card` : Carte d'événement individuelle
- `.ca-event-details` : Détails de l'événement
- `.ca-event-date` : Date de l'événement
- `.ca-event-title` : Titre de l'événement
- `.ca-event-actions` : Zone des actions (boutons)
- `.ca-event-image` : Image de l'événement
- `.ca-btn` : Bouton d'action

## Gestion des erreurs

Le plugin gère automatiquement :

- Erreurs de connexion à l'API Discord
- Tokens invalides
- Serveurs inexistants
- Absence d'événements

En cas d'erreur, le message "Aucun évènement trouvé." est affiché.

## Sécurité

- Sanitisation des données utilisateur avec `sanitize_text_field()`
- Échappement des données d'affichage avec `esc_attr()` et `esc_html()`
- Vérification des permissions administrateur
- Timeout des requêtes API configuré

## Support

Pour toute question ou problème :

- Repo Gitea : [https://git.crystalyx.net/camelia-studio/UWU_Evelia](https://git.crystalyx.net/camelia-studio/UWU_Evelia)
- Site web : [https://camelia-studio.org](https://camelia-studio.org)
- Version : 1.0.0

## Changelog

### 1.0.0
- Version initiale
- Intégration des événements Discord
- Interface d'administration
- Système de cache
- Personnalisation des couleurs