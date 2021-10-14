=== Tokenpass OAuth 2.0 ===
Contributors: Nick Arora
Donate link: https://www.tokenly.com/
Tags: tokenly, api, tokenpass
Requires at least: 4.5
Tested up to: 5.8.1
Requires PHP: 5.6
Stable tag: 0.1.0
License: MIT
License URI: https://choosealicense.com/licenses/mit/

Integrates Tokenpass features.

== Installation ==

1. Create an account on tokenpass.tokenly.com
2. Go to the "developers" section
3. Create a new Client Application
4. Set name and home page URL
5. Set redirect URL to: https://YOUR_DOMAIN/wp-content/plugins/tokenly-wp-plugin-main/account/authorize/callback.php
6. Install and activate the Wordpress plugin
7. Find the "Tokenpass" menu item in the sidebar for plugin settings
8. Save the Client ID and Client Secret provided from the Developers sectionon Tokenpass

== Usage ==

Use the shortcode [tokenpass_login] on a page to display the Login button
