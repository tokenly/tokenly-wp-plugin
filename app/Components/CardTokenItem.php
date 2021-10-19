<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Routes\ApiRouter;

class CardTokenItem {	
	public $balance = array();

	public function __construct( $data ) {
		$this->balance = $data['balance'] ?? null;
	}

	public function render() {
		$html = "
			<div class='tokenly-component component-card-token-item'>
				<div class='token-name'>{$this->balance['name']}</div>
				<div class='token-balance'>{$this->balance['balance']}</div>
			</div>
		";
		return $html;
	}
}