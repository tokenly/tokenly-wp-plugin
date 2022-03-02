<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaShortcodeInterface;

class MetaShortcode extends Shortcode implements MetaShortcodeInterface {
	/**
	 * @inheritDoc
	 */
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ): array {
		return array(
			'template' => 'shortcodes/Token/MetaShortcode.twig',
			'data'     => $atts,
		);
	}
}
