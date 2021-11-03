<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;

/**
 * Manages blockchain addresses
 */
class AddressRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client
	) {
		$this->client = $client;
	}

	public function index( $username ) {
		$addresses = $this->client->getPublicAddresses( $username );
		return $addresses;
	}
}
