<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\CardTokenItem; 

class ListCardTokenItem {	
	public $balances = array();

	public function __construct( $data ) {
		$this->balances = $data['balances'] ?? null;
	}

	public function render() {
		$html_token_items = '';
		foreach ( $this->balances as $balance ) {
			$token_item = new CardTokenItem( array( 'balance' => $balance, ) );
			$html_token_items .= $token_item->render();
		}
		$html = "
			<div class='tokenly-component block-list-card-token-item'>
				<div class='row'>
					<div class='container'>
						{$html_token_items}
					</div>
				</div>
			</div>
		";
		return $html;
	}
}