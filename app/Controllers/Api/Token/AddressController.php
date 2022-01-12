<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

/**
 * Defines address endpoints
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
	 * Gets a single addresse
	 * @param AddressInterface $address Bound address
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( AddressInterface $address, \WP_REST_Request $request ) {
		$address = $address->to_array();
		return $address;
	}

	/**
	 * Gets a collection of balance
	 * @param AddressInterface $user Bound address
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function balance_index( AddressInterface $address, \WP_REST_Request $request ) {
		$address->load( array( 'balance.meta' ) );
		if ( !isset( $address->balance ) || $address->balance instanceof BalanceCollectionInterface === false ) {
			return array();
		}
		$balance = $address->balance->to_array();
		return $balance;
	}

	protected function remap_parameters( array $params = array() ) {
		if ( isset( $params['id'] ) ) {
			$params['address'] = $params['id'];
			unset( $params['id'] );
		}
		return $params;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->address_service,
			'single_methods'            => array( 'show', 'balance_index' ),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
