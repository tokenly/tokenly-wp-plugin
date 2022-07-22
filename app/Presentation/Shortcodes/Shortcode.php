<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\ShortcodeInterface;

class Shortcode extends Service implements ShortcodeInterface {
	/**
	 * Prepares the shortcode template data for rendering
	 * @param array $atts Shortcode parameters
	 * @param string $content
	 * @param string $tag
	 * @return array
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		return array();
	}

	/**
	 * Registers the shortcode
	 * @return void
	 */
	public function register(): void {
		//
	}
}
