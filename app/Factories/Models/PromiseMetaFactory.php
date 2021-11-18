<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseMetaFactory extends Factory implements PromiseMetaFactoryInterface {
	/**
	 * Creates a new promise meta object
	 * @param array $data New promise meta data
	 * @param array $args Additional parameters
	 * @return PromiseMetaInterface
	 */
	public function create( $data, $args = array() ) {
		$promise_meta = $this->factory->create( array(
			'post' => $data,
		) );
		return $promise_meta;
	}
}
