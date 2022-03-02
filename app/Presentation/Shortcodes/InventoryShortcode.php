<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\InventoryShortcodeInterface;

class InventoryShortcode extends Shortcode implements InventoryShortcodeInterface {
	/**
	 * @inheritDoc
	 */
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ): array {
		return array(
			'template' => 'shortcodes/InventoryShortcode.twig',
			'data'     => $atts,
		);
	}
}
