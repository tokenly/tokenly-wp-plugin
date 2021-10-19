<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Shortcodes\LoginButtonShortcode;

class ShortcodeServiceProvider {
	public $shortcodes;

	public function boot(
		LoginButtonShortcode $login_button_shortcode
	) {
		$this->shortcodes = array(
			$login_button_shortcode,
		);
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	public function register_shortcodes() {
		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode->name, array( $shortcode, 'shortcode_callback' ) );
		}
	}
}
