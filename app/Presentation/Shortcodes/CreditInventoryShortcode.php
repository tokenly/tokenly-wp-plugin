<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\CreditInventoryShortcodeInterface;

use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;

class CreditInventoryShortcode extends Shortcode implements CreditInventoryShortcodeInterface {
	protected $app_credit_item_card_list_block_model;

	public function __construct(
		AppCreditItemCardListBlockModelInterface $app_credit_item_card_list_block_model
	) {
		$this->app_credit_item_card_list_block_model = $app_credit_item_card_list_block_model;
	}

	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ) {
		$data = $this->app_credit_item_card_list_block_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/CreditInventoryShortcode.twig',
			'data'     => $data,
		);
	}
}
