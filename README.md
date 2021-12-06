# Tokenly WordPress Integration

The plugin integrates Tokenly & Tokenpass features into a WordPress website.

## Installation

1. Clone the repository from the /plugins directory.
2. Run `composer install` within the plugin's directory once to install the dependencies.
3. Activate the WordPress plugin.
4. Follow the instructions on the Tokenly > Settings page.

If it is not working, make sure your permalink rewrite rules cache is flushed.

## Usage

Tokenpass login button is automatically included on the WP login screen

Use the shortcode [tokenly_login] on a page to display the Login button as well.

## Contributing

[WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) are followed with the exception to filenames and classnames. The exceptions are due to Composer's autoloader requirements. It expects PSR-4 styled code for autoloading to work.

* ```test.sh``` is used to run tests and check code style
* ```test-fix.sh``` is used to fix styling issues automatically
* ```test-local-install.sh``` is used to prepare the database for testing, is expecting a running WordPress instance via [Local by Flywheel](https://localwp.com/)

[Tokenpass Client](https://github.com/tokenly/tokenpass-client) library was merged with the codebase. It can be found in the ```libs``` directory.

[Kint](https://github.com/kint-php/kint/) is bundled for debugging purposes.

## License

[MIT](https://choosealicense.com/licenses/mit/)
