<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseFactory extends Factory implements PromiseFactoryInterface {
	/**
	 * Creates a new promise object
	 * @param array $promise_data New promise data
	 * @return PromiseInterface
	 */
	public function create( $data, $args = array() ) {
		if ( isset( $data['quantity'] ) && isset( $data['precision'] ) ) {
			$quantity = $data['quantity'] ?? null;
			$precision = $data['precision'] ?? null;
			if ( $precision > 0 ) {
				$divisor = intval( 1 . str_repeat( 0, $precision ) );
				$quantity = $quantity / $divisor;
				$data['quantity'] = $quantity;
			}
		}
		$promise = $this->factory->create( array(
			'promise_data' => $data,
		) );
		return $promise;
	}
}
