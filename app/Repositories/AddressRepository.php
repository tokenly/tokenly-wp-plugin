<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	public $client;
	
	public function __construct(
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
	}

	/**
	 * Gets the list of public addresses for the username
	 * @param string $username Tokenpass username
	 */
	public function index( $username ) {
		$addresses = $this->client->getPublicAddresses( $username );
		return $addresses;
	}
}
