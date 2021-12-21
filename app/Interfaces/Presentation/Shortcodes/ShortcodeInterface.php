<?php

namespace Tokenly\Wp\Interfaces\Presentation\Shortcodes;

interface ShortcodeInterface {
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' );
}
