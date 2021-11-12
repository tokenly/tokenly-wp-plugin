<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;

class Source implements SourceInterface {
	public $address;
	public $address_data;
	public $assets;
	public $type;
	protected $source_repository;

	public function __construct(
		$source_data = array(),
		SourceRepositoryInterface $source_repository
	) {
		$this->address = $source_data['address'] ?? null;
		$this->assets = $source_data['assets'] ?? null;
		$this->type = $source_data['type'] ?? null;
		$this->source_repository = $source_repository;
	}

	/**
	 * Updates the source data
	 * @param array $params New source data
	 * @return void
	 */
	public function update( $params ) {
		$this->source_repository->update( $this->address, $params );
	}

	/**
	 * Destroys the source
	 * @return void
	 */
	public function destroy() {
		$this->source_repository->destroy( $this->address );
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
