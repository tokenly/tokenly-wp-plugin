<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Factories\Factory;

class SourceFactory extends Factory implements SourceFactoryInterface {
	/**
	 * Creates a new source object
	 * @param array $source_data New source data
	 * @return SourceInterface
	 */
	public function create( $data, $args = array() ) {
		$source = $this->factory->create( array(
			'source_data' => array(
				'address' => $data['address'] ?? null,
				'assets'  => $data['assets'] ?? null,
				'type'    => $data['type'] ?? null,
			),
		) );
		return $source;
	}
}
