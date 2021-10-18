<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Shortcodes\LoginButtonShortcode;

class ShortcodeServiceProvider {
	public function boot() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}
	
	public function get_shortcodes() {
		return array(
			LoginButtonShortcode::class,
		);
	}

	public function register_shortcodes() {
		$shortcodes = $this->get_shortcodes();
		foreach ( $shortcodes as $shortcode ) {
			$shortcode = new $shortcode();
			add_shortcode( $shortcode->name, array( $shortcode, 'shortcode_callback' ) );
		}
	}
}
