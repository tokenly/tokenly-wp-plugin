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
		    array(
				'name'		=> 'tokenpass_login',
				'instance'  => $login_button_shortcode,
			),
			array(
				'name'		=> 'tokenpass_logout',
				'instance'  => $logout_button_shortcode,
			),
		);
	}

	/**
	 * Registers the service provider
	 * @return void
	 */
	public function register() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	/**
	 * Registers all shortcodes
	 * @wp-hook init
	 * @return void
	 */
	public function register_shortcodes() {
		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode['name'], array( $shortcode['instance'], 'shortcode_callback' ) );
		}
	}
}
