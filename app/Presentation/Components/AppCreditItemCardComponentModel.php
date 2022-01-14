<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;

class AppCreditItemCardComponentModel extends ComponentModel implements AppCreditItemCardComponentModelInterface {	
	public function prepare( array $data = array() ) {
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
		return array(
			'name'   => $name,
			'balance' => $balance,
		);
	}
}
