<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Factories\Factory;

class TokenMetaFactory extends Factory implements TokenMetaFactoryInterface {
	/**
	 * Creates a new token meta object
	 * @param array $data New token meta data
	 * @param array $args Additional parameters
	 * @return TokenMetaInterface
	 */
	public function create( $data, $args = array() ) {
		$token_meta = $this->factory->create( array(
			'post' => $data,
		) );
		return $token_meta;
	}
}
