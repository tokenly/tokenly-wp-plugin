<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class Address extends Model implements AddressInterface {
	public $address = '';
	public $type = '';
	public $label = 'Unnamed';
	public $balances;
	protected $source_service;

	public function __construct(
		SourceServiceInterface $source_service,
		array $data = array()
	) {
		$this->source_service = $source_service;
		$this->fill( $data );
	}

	public function fill( array $data ) {
		if ( isset( $data['address'] ) ) {
			$this->address = $data['address'];
		}
		if ( isset( $data['type'] ) ) {
			$this->type = $data['type'];
		}
		if ( isset( $data['label'] ) ) {
			$this->label = $data['label'];
		}
		if ( isset( $data['balances'] ) ) {
			$this->balances = $data['balances'];
		}
	}

	public function to_array() {
		$array = array();
		if ( isset( $this->address ) ) {
			$array['address'] = $this->address;
		}
		if ( isset( $this->type ) ) {
			$array['type'] = $this->type;
		}
		if ( isset( $this->label ) ) {
			$array['label'] = $this->label;
		}
		$balances = array();
		if ( isset( $this->balances ) && $this->balances instanceof BalanceCollectionInterface ) {
			$balances = $this->balances->to_array();
		}
		$array['balances'] = $balances;
		return $array;
	}

	public function register( string $assets = '' ) {
		if ( !isset( $this->address ) || !isset( $this->type ) ) {
			return;
		}
		$payload = array(
			'address' => $this->address,
			'type'    => $this->type,
			'assets'  => $assets,
		);
		$this->source_service->store( $payload );
	}
}
