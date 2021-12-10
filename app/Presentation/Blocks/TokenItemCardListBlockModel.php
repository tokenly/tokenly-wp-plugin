<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\TokenItemCardComponentModelInterface; 

class TokenItemCardListBlockModel extends BlockModel implements TokenItemCardListBlockModelInterface {
	public $card_token_item_component_model;

	public function __construct(
		TokenItemCardComponentModelInterface $token_item_card_component_model
	) {
		$this->token_item_card_component_model = $token_item_card_component_model;
	}

	public function prepare( array $data = array() ) {
		if ( !isset( $data['balance'] ) ) {
			return false;
		}
		$token_items = array();
		$balances = $data['balance'];
		foreach ( ( array ) $balances as $balance ) {
			$token_items[] = $this->token_item_card_component_model->prepare( array( 'balance' => $balance, ) );
		}
		return array(
			'token_items' => $token_items,
		);
	}
}
