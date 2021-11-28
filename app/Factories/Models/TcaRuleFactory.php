<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\TcaRuleFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;
use Tokenly\Wp\Factories\Factory;

class TcaRuleFactory extends Factory implements TcaRuleFactoryInterface {
	/**
	 * Creates a new user decorator
	 * @param array $params New TCA rule data
	 * @return TcaRuleInterface
	 */
	public function create( $data, $args = array() ) {
		$instance = $this->factory->create( array(
			'rule_data' => $data,
		) );
		return $instance;
	}
}
