<?php

namespace Tokenly\Wp\Components;

class CardAppCreditItemComponentModel {	

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
