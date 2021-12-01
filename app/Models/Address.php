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
	protected $domain_service;
	protected $fillable = array(
		'address',
		'type',
		'label',
		'balances',
	);

	public function __construct(
		SourceServiceInterface $domain_service,
		array $data = array()
	) {
		$this->domain_service = $domain_service;
		parent::__construct( $data );
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
		$this->domain_service->store( $payload );
	}
}
