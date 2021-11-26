<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Shortcodes\LogoutButtonShortcode;

/**
 * Registers shortcodes
 */
class ShortcodeServiceProvider extends ServiceProvider implements ShortcodeServiceProviderInterface {
	protected $shortcodes;

	public function __construct(
		LoginButtonShortcode $login_button_shortcode,
		LogoutButtonShortcode $logout_button_shortcode
	) {
		$this->shortcodes = array(
			'tokenpass_login'  => $login_button_shortcode,
			'tokenpass_logout' => $logout_button_shortcode,
		);
	}

	/**
	 * Registers the services
	 * @return void
	 */
	public function register() {
		foreach ( $this->shortcodes as $key => $shortcode ) {
			add_shortcode( $key, array( $shortcode, 'shortcode_callback' ) );
		}
	}
}
