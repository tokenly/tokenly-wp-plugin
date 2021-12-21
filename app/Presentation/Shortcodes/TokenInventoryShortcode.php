<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\TokenInventoryShortcodeInterface;

use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;

class TokenInventoryShortcode extends Shortcode implements TokenInventoryShortcodeInterface {
	protected $token_item_card_list_block_model;

	public function __construct(
		TokenItemCardListBlockModelInterface $token_item_card_list_block_model
	) {
		$this->token_item_card_list_block_model = $token_item_card_list_block_model;
	}

	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ) {
		$data = $this->token_item_card_list_block_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/TokenInventoryShortcode.twig',
			'data'     => $data,
		);
	}
}
