<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Shortcodes\LoginButtonShortcode;

class ShortcodeManager {
	public function __construct() {
		//
	}

	public function init() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}
	
	public function get_shortcodes() {
		return [
			LoginButtonShortcode::class,
		];
	}

	public function register_shortcodes() {
		$shortcodes = $this->get_shortcodes();
		foreach ( $shortcodes as $shortcode ) {
			$shortcode = new $shortcode();
			add_shortcode( $shortcode->name, array( $shortcode, 'shortcode_callback' ) );
		}
	}
}
