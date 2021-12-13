<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;

class AppCreditItemCardComponentModel extends ComponentModel implements AppCreditItemCardComponentModelInterface {	
	public function prepare( array $data = array() ) {
		$account = $data['account'];
		$key = $data['key'];
		$credit_groups = $data['credit_groups'];
		$name = null;
		if ( isset( $credit_groups[ $key ] ) ) {
			$group = $credit_groups[ $key ];
			$name = $group->name;
		}
		$balance = $account->balance;
		return array(
			'name'   => $name,
			'balance' => $balance,
		);
	}
}
