<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;

class Source extends Model implements SourceInterface {
	public $address_id;
	public $address;
	public $assets;
	public $type;
	protected $address_service;
	protected $current_user;
	protected $fillable = array(
		'address_id',
		'address',
		'assets',
		'type'
	);

	public function __construct(
		SourceRepositoryInterface $domain_repository,
		AddressServiceInterface $address_service,
		CurrentUserInterface $current_user,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->address_service = $address_service;
		$this->current_user = $current_user;
		parent::__construct( $data );
	}

	/**
	 * Loads the address relation
	 * @param array $relations Further relations
	 * @return AddressInterface 
	 */
	protected function load_address( array $relations = array() ) {
		$address = $this->address_service->show( array(
			'address' => $this->address_id,
			'with'    => $relations,
		) );
		return $address;
	}
}
