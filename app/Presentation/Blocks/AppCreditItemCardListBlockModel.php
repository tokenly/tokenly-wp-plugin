<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;

class AppCreditItemCardListBlockModel extends BlockModel implements AppCreditItemCardListBlockModelInterface {
	public $app_credit_item_card_component_model;

	public function __construct(
		AppCreditItemCardComponentModelInterface $app_credit_item_card_component_model
	) {
		$this->app_credit_item_card_component_model = $app_credit_item_card_component_model;
	}

	public function prepare( array $data = array() ) {
		if ( 
			!isset( $data['credit_accounts'] ) ||
			!isset( $data['credit_groups'] )
		) {
			return;
		}
		$credit_items = array();
		$credit_accounts = $data['credit_accounts'];
		$credit_groups = $data['credit_groups'];
		$credit_groups->key_by_field( 'uuid' );
		foreach ( ( array ) $credit_accounts as $key => $account ) {
			$credit_items[] = $this->app_credit_item_card_component_model->prepare( array(
					'credit_groups' => $credit_groups,
					'account'       => $account,
					'key'           => $key,
				)
			);
		}
		return array(
			'credit_items' => $credit_items,
		);
	}
}
