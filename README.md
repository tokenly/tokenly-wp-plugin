# Tokenly WordPress Integration

The plugin integrates Tokenpass features into a WordPress website.

## Installation

1. Create an account on tokenpass.tokenly.com
2. Go to the "developers" section
3. Create a new Client Application
4. Set name and home page URL
5. Set redirect URL to: https://YOUR_DOMAIN/wp-content/plugins/tokenly-wp-plugin-main/account/authorize/callback.php
6. Install and activate the Wordpress plugin
7. Find the "Tokenpass" menu item in the sidebar for plugin settings
8. Save the Client ID and Client Secret provided from the Developers sectionon Tokenpass

## Usage

Use the shortcode [tokenpass_login] on a page to display the Login button

## Contributing
[WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) are followed with the exception to filenames and classnames. The exceptions are due to Composer's autoloader requirements. It expects PSR-4 styled code for autoloading to work.

* ```test.sh``` is used to run tests and check code style
* ```test-fix.sh``` is used to fix styling issues automatically
* ```test-local-install.sh``` is used to prepare the database for testing, is expecting a running WordPress instance via [Local by Flywheel](https://localwp.com/)

[Tokenpass Client](https://github.com/tokenly/tokenpass-client) library was merged with the codebase. It and its dependencies can be found in the ```libs``` directory.

## License
[MIT](https://choosealicense.com/licenses/mit/)
