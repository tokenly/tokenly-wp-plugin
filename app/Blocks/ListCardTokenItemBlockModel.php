<?php

namespace Tokenly\Wp\Blocks;

use Tokenly\Wp\Components\CardTokenItemComponentModel; 

class ListCardTokenItemBlockModel {
	public $card_token_item_component_model;

	public function __construct(
		CardTokenItemComponentModel $card_token_item_component_model
	) {
		$this->card_token_item_component_model = $card_token_item_component_model;
	}

	public function prepare( array $data = array() ) {
		if ( !isset( $data['balance'] ) ) {
			return false;
		}
		$token_items = array();
		$balances = $data['balance'];
		foreach ( ( array ) $balances as $balance ) {
			$token_items[] = $this->card_token_item_component_model->prepare( array( 'balance' => $balance, ) );
		}
		return array(
			'token_items' => $token_items,
		);
	}
}
