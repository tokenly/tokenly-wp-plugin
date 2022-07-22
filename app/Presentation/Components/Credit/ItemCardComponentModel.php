<?php

namespace Tokenly\Wp\Presentation\Components\Credit;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\Credit\ItemCardComponentModelInterface;

class ItemCardComponentModel extends ComponentModel implements ItemCardComponentModelInterface {	
	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$account = $data['account'];
		$balance = null;
		$name = null;
		if ( isset( $data['group'] ) ) {
			$group = $data['group'];
			$name = $group->name;
		}
		if ( isset( $data['account'] ) ) {
			$balance = $account->balance;
		}
		$card = array(
			'name'   => $name,
			'balance' => $balance,
		);
		return $card;
	}
}
