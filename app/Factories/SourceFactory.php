<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Factories\Factory;

class SourceFactory extends Factory implements SourceFactoryInterface {
	/**
	 * Creates a new source object
	 * @param array $source_data New source data
	 * @return SourceInterface
	 */
	public function create( $params ) {
		$source = $this->factory->create( array(
			'source_data' => array(
				'address' => $params['address'] ?? null,
				'assets'  => $params['assets'] ?? null,
				'type'    => $params['type'] ?? null,
			),
		) );
		return $source;
	}
}
