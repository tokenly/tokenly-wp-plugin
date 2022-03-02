<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\InventoryShortcodeInterface;

use Tokenly\Wp\Interfaces\Presentation\Blocks\Token\ItemCardListBlockModelInterface;

class InventoryShortcode extends Shortcode implements InventoryShortcodeInterface {
	protected ItemCardListBlockModelInterface $item_card_list_block_model;

	public function __construct(
		ItemCardListBlockModelInterface $item_card_list_block_model
	) {
		$this->item_card_list_block_model = $item_card_list_block_model;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ): array {
		$data = $this->item_card_list_block_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/Token/InventoryShortcode.twig',
			'data'     => $data,
		);
	}
}
