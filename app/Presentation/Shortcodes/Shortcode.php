<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\ShortcodeInterface;

class Shortcode extends Service implements ShortcodeInterface {
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ) {
		//
	}

	public function register() {
		//
	}
}
