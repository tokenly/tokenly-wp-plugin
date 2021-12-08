<?php

namespace Tokenly\Wp\Blocks;

use Tokenly\Wp\Components\CardAppCreditItemComponent; 
use Tokenly\Wp\Components\Component;
use Twig\Environment;

class ListCardAppCreditItemBlock extends Component {
	public $card_app_credit_item_component;

	public function __construct(
		Environment $twig,
		CardAppCreditItemComponent $card_app_credit_item_component
	) {
		parent::__construct( $twig );
		$this->card_app_credit_item_component = $card_app_credit_item_component;
	}

	public function render( $data ) {
		if ( 
			!isset( $data['credit_accounts'] ) ||
			!isset( $data['credit_groups'] )
		) {
			return;
		}
		$html_app_credit_items = '';
		$credit_accounts = $data['credit_accounts'];
		$credit_groups = $data['credit_groups'];
		$credit_groups->key_by_field( 'uuid' );
		foreach ( ( array ) $credit_accounts as $key => $account ) {
			$name = null;
			if ( isset( $credit_groups[ $key ] ) ) {
				$group = $credit_groups[ $key ];
				$name = $group->name;
			}
			$balance = $account->balance;
			$html_app_credit_items .= $this->card_app_credit_item_component->render( array(
				'name'    => $name,
				'balance' => $balance,
			)
		);
		}
		$html = $this->twig->render( 'blocks/ListCardAppCreditItemBlock.twig', array(
			'credit_items' => $html_app_credit_items,
		) );
		return $html;
	}
}
