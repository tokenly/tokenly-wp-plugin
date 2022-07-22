<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Credit;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Credit\InventoryShortcodeInterface;

use Tokenly\Wp\Interfaces\Presentation\Blocks\Credit\ItemCardListBlockModelInterface;

class InventoryShortcode extends Shortcode
	implements InventoryShortcodeInterface
{
	protected ItemCardListBlockModelInterface $item_card_list_block_model;

	public function __construct(
		ItemCardListBlockModelInterface $item_card_list_block_model
	) {
		$this->item_card_list_block_model = $item_card_list_block_model;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		$data = $this->item_card_list_block_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/Credit/InventoryShortcode.twig',
			'data'     => $data,
		);
	}
}
