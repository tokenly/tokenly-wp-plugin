<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Shortcodes\LoginButtonShortcode;

class ShortcodeManager {
	public function __construct() {
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
			$name = $shortcode::$name;
			add_shortcode( $name, [$shortcode, 'shortcode_callback'] );
		}
	}
}
