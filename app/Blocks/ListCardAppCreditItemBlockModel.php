<?php

namespace Tokenly\Wp\Blocks;

use Tokenly\Wp\Components\CardAppCreditItemComponentModel; 

class ListCardAppCreditItemBlockModel {
	public $card_app_credit_item_component_model;

	public function __construct(
		CardAppCreditItemComponentModel $card_app_credit_item_component_model
	) {
		$this->card_app_credit_item_component_model = $card_app_credit_item_component_model;
	}

	public function prepare( array $data = array() ) {
		if ( 
			!isset( $data['credit_accounts'] ) ||
			!isset( $data['credit_groups'] )
		) {
			return;
		}
		$app_credit_items = array();
		$credit_accounts = $data['credit_accounts'];
		$credit_groups = $data['credit_groups'];
		$credit_groups->key_by_field( 'uuid' );
		foreach ( ( array ) $credit_accounts as $key => $account ) {
			$app_credit_items[] = $this->card_app_credit_item_component_model->prepare( array(
					'credit_groups' => $credit_groups,
					'account'       => $account,
					'key'           => $key,
				)
			);
		}
		return array(
			'credit_items' => $app_credit_items,
		);
	}
}
