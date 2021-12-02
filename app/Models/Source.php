<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class Source extends Model implements SourceInterface {
	public $address;
	public $address_data;
	public $assets;
	public $type;
	protected $source_service;
	protected $source_repository;
	protected $address_service;
	protected $current_user;
	protected $fillable = array(
		'address',
		'address_data',
		'assets',
		'type'
	);

	public function __construct(
		SourceServiceInterface $source_service,
		SourceRepositoryInterface $source_repository,
		AddressServiceInterface $address_service,
		CurrentUserInterface $current_user,
		array $data = array()
	) {
		$this->source_service = $source_service;
		$this->source_repository = $source_repository;
		$this->address_service = $address_service;
		$this->current_user = $current_user;
		parent::__construct( $data );
	}

	/**
	 * Appends Address object to the queried source
	 * @param array $relations Relations
	 * @return self 
	 */
	protected function load_address( array $relations = array() ) {
		$address = $this->address_service->show( array(
			'address' => $this->address,
			'with'    => $relations,
		) );
		if ( $address ) {
			$this->address_data = $address;
		}
		return $this;
	}

		/**
	 * Updates the exisiting source by address
	 * @param array $params New source data
	 * @return boolean
	 */
	public function update( array $params ) {
		return $this->source_service->store( $params );
	}

	/**
	 * Destroys the existing source by address
	 * @param string $address
	 * @return void
	 */
	public function destroy( string $address ) {
		$this->source_repository->destroy( $address );
	}
}
