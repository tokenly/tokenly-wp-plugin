<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository implements AddressRepositoryInterface {
	protected $client;
	
	public function __construct(
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
	}

	/**
	 * Gets the list of public addresses for the username
	 * @param string $username Tokenpass username
	 */
	public function index( $params = array() ) {
		$username = $params['username'] ?? null;
		if ( !$username ) {
			return;
		}
		$addresses = $this->client->getPublicAddresses( $username );
		return $addresses;
	}
}
