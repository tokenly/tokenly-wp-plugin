<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class Source implements SourceInterface {
	public $address;
	public $address_data;
	public $assets;
	public $type;
	protected $source_service;

	public function __construct(
		$source_data = array(),
		SourceServiceInterface $source_service
	) {
		$this->address = $source_data['address'] ?? null;
		$this->assets = $source_data['assets'] ?? null;
		$this->type = $source_data['type'] ?? null;
		$this->source_service = $source_service;
	}

	/**
	 * Updates the source data
	 * @param array $params New source data
	 * @return void
	 */
	public function update( $params ) {
		return $this->source_service->update( $this->address, $params );
	}

	/**
	 * Destroys the source
	 * @return void
	 */
	public function destroy() {
		$this->source_service->destroy( $this->address );
	}

	/**
	 * Converts the source to array
	 */
	public function to_array() {
		$array = array(
			'address' => $this->address,
			'address_data' => $this->address_data,
			'assets'  => $this->assets,
			'type'    => $this->type,
		);
		return $array;
	}
}
