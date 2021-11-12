<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfcaes\Collections\BalanceCollectionInterface;

class Address implements AddressInterface {
	public $address;
	public $type;
	public $balances;
	public $label;
	protected $source_repository;

	public function __construct(
		$address_data,
		SourceRepositoryInterface $source_repository,
		BalanceCollectionFactoryInterface $balance_collection_factory
	) {
		$this->source_repository = $source_repository;
		$this->balance_collection_factory = $balance_collection_factory;
		$this->from_array( $address_data );
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
	
	protected function from_array( $address_data ) {
		if ( isset( $address_data['address'] ) ) {
			$this->address = $address_data['address'] ?? null;
		}
		if ( isset( $address_data['type'] ) ) {
			$this->type = $address_data['type'] ?? null;
		}
		if ( isset( $address_data['balances'] ) ) {
			$balances = $address_data['balances'] ?? null;
			if ( is_a( $balances, BalanceCollectionFactoryInterface::class ) ) {
				$this->balances = $balances;
			} else {
				$this->balances = $this->balance_collection_factory->create( $balances );
			}
		}
		if ( isset( $address_data['label'] ) ) {
			$this->label = $address_data['label'] ?? null;
		}
	}
}
