<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;

class IntegrationRepository implements IntegrationRepositoryInterface {
	protected $client;
	
	public function __construct(
		TokenpassAPIInterface $client
	) {
		$this->client = $client;
	}

	/**
	 * Gets intergration status
	 * @return bool
	 */
	public function show() {
		$result = $this->client->getProvisionalSourceList();
		if ( $result === false ) {
			return false;
		} else {
			if ( is_array( $result ) === true ) {
				return true;
			}
		}
	}
	
}
