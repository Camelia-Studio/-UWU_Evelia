=== Evelia ===
Contributors: cameliastudio
Donate link: https://fr.tipeee.com/asso-camelia
Tags: discord, events, calendar, shortcode, scheduled events
Requires at least: 5.2
Tested up to: 6.9
Stable tag: 1.0.11
Requires PHP: 8.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display your Discord server's scheduled events directly on your WordPress site using a simple shortcode.

== Description ==

Evelia connects your Discord server to your WordPress site to automatically display your scheduled events. Using the Discord API, the plugin retrieves and presents events as customizable visual cards.

**Main features:**

* Automatic event retrieval via Discord API v10
* Display via the `[evelia_events]` shortcode
* Filter events by keyword in their description
* Smart caching (12 hours) with automatic invalidation when configuration changes
* Two layout options: horizontal (image on the right) and vertical (image on top)
* Full color customization (background, titles, buttons, dates, etc.)
* Fully configurable texts (block title, description, button text, no-events message)
* Live color preview in the admin interface
* Manual cache flush button

**Shortcode usage:**

Insert `[evelia_events]` into any WordPress page or post to display the list of events from your Discord server.

== Installation ==

1. Upload the `evelia` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin from the **Plugins** menu in your WordPress dashboard.
3. Go to **Settings > Evelia** to configure the plugin.
4. Fill in the required fields:
   * **Discord Bot Token** — the authentication token of your Discord bot.
   * **Discord Server ID** — the numeric identifier of your server (Guild ID).
   * **Discord Invite URL** — the base link to your server (e.g. `https://discord.gg/myserver`).
5. (Optional) Enter a keyword in the **Word to search** field to display only events whose description contains that word.
6. Insert the shortcode `[evelia_events]` into any page.

== Frequently Asked Questions ==

= How do I get a Discord bot token? =

Go to the [Discord Developer Portal](https://discord.com/developers/applications), create a new application, then under the **Bot** tab, generate and copy the token. Make sure your bot is invited to your server with the necessary permissions to read scheduled events (`MANAGE_EVENTS` or `VIEW_GUILD_INSIGHTS`).

= How do I find my Discord server ID? =

Enable **Developer Mode** in Discord settings (Appearance > Developer Mode), then right-click on your server icon and select **Copy ID**.

= Events are not showing. What should I do? =

Check that the bot token and server ID are correctly set. If you just changed the configuration, clear the cache from the **Configuration** tab (using the **Clear Cache** button). Also make sure your Discord server has active or upcoming scheduled events.

= How often are events updated? =

Events are cached for 12 hours. The cache is automatically invalidated when you change the token, server ID, or filter keyword. You can also clear it manually from the **Configuration** tab.

= Can I display multiple event blocks on the same page? =

The `[evelia_events]` shortcode is designed for a single display per page, reflecting the plugin's global configuration.

= How do I customize the card appearance? =

Go to **Settings > Evelia**, **Customization** tab. You can change background, title, button, and date colors, with a live preview of your changes.

== Screenshots ==

1. Configuration page — Configuration tab (Discord).
2. Configuration page — Customization tab with live preview.
3. Configuration page — Layout tab.
4. Configuration page — Texts tab.
5. Frontend display — horizontal layout.
6. Frontend display — vertical layout.

== Changelog ==

= 1.0.11 =
* Fixed Plugin Check errors and warnings for WordPress.org compliance.

= 1.0.10 =
* Added readme.txt for WordPress.org.

= 1.0.9 =
* Improved cache invalidation logic when Discord settings change.

= 1.0.8 =
* Added vertical layout for event cards.
* Live color preview in the admin interface.

= 1.0.0 =
* Initial stable release.
* Discord event retrieval via API v10.
* `[evelia_events]` shortcode.
* Transient-based caching (12 hours).
* Admin interface with color and text customization.

== Upgrade Notice ==

= 1.0.9 =
Recommended update: improved cache management. The cache will be automatically invalidated when Discord configuration changes.
