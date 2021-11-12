<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class Address implements AddressInterface {
	public $address;
	public $type;
	public $label;
	public $balances;
	protected $source_repository;

	public function __construct(
		string $address = '',
		string $type = '',
		string $label = 'Unnamed',
		BalanceCollectionInterface $balances,
		SourceRepositoryInterface $source_repository
	) {
		$this->source_repository = $source_repository;
		$this->address = $address;
		$this->type = $type;
		$this->label = $label;
		$this->balances = $balances;
	}

	public function to_array() {
		$balances = $this->balances->to_array();
		$array = array(
			'address'  => $this->address,
			'type'     => $this->type,
			'balances' => $balances,
			'label'    => $this->label,
		);
		return $array;
	}

	public function register( $assets = '' ) {
		$payload = array(
			'address' => $this->address,
			'type'    => $this->type,
			'assets'  => $assets,
		);
		$this->source_repository->store( $payload );
	}
}
