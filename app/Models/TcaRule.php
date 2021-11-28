<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;

class TcaRule implements TcaRuleInterface {
	public $asset;
	public $quantity;
	public $op;
	public $stackOp;

	public function __construct(
		array $rule_data
	) {
		$this->from_array( $rule_data );
	}

	public function from_array( $rule_data ) {
		if ( isset( $rule_data['asset'] ) ) {
			$this->asset = $rule_data['asset'];
		}
		if ( isset( $rule_data['quantity'] ) ) {
			$this->quantity = $rule_data['quantity'];
		}
		if ( isset( $rule_data['op'] ) ) {
			$this->op = $rule_data['op'];
		}
		if ( isset( $rule_data['stackOp'] ) ) {
			$this->stackOp = $rule_data['stackOp'];
		}
		return $this;
	}

	public function to_array() {
		return array(
			'asset'    => $this->asset,
			'quantity' => $this->quantity,
			'op'       => $this->op,
			'stackOp'  => $this->stackOp,
		);
	}
}
