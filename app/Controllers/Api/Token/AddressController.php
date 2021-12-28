<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

/**
 * Defines API endpoints for addresses
 */
class AddressController extends Controller implements AddressControllerInterface {
	protected $address_service;

	public function __construct(
		AddressServiceInterface $address_service
	) {
		$this->address_service = $address_service;
	}
	
	/**
	 * Gets a collection of addresses
	 * @param AddressCollectionInterface $addresses Bound addresses
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( AddressCollectionInterface $addresses, \WP_REST_Request $request ) {
		$addresses = $addresses->to_array();
		return $addresses;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->address_service,
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
