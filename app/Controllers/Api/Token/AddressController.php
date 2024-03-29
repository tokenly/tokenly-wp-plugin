<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines address endpoints
 */
class AddressController extends Controller
	implements AddressControllerInterface
{
	protected AddressRepositoryInterface $address_repository;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		AddressRepositoryInterface $address_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->address_repository = $address_repository;
		$this->user_repository = $user_repository;
	}
	
	/**
	 * Gets a collection of addresses
	 * @param \WP_REST_Request $request Request data
	 * @param AddressCollectionInterface $addresses Bound addresses
	 * @return \WP_REST_Response
	 */
	public function index(
		\WP_REST_Request $request, AddressCollectionInterface $addresses
	): \WP_REST_Response {
		$addresses = $addresses->to_array();
		return new \WP_REST_Response( $addresses );
	}

	/**
	 * Gets a single addresse
	 * @param \WP_REST_Request $request Request data
	 * @param AddressInterface $address Bound address
	 * @return \WP_REST_Response
	 */
	public function show(
		\WP_REST_Request $request, AddressInterface $address = null
	): \WP_REST_Response {
		if ( $address ) {
			$address = $address->to_array();
		}
		return new \WP_REST_Response( $address );
	}

	/**
	 * Makes a new address
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function store( \WP_REST_Request $request ): \WP_REST_Response {
		$params = $request->get_params();
		$params = $this->remap_parameters( $params );
		$address = $this->address_repository->store( $params );
		$status;
		if ( $address ) {
			$status = 'Successfully registered the address!';
		} else {
			$status = 'Failed to register the address!';
		}
		return new \WP_REST_Response( array(
			'address' => null,
			'status'  => $status,
		) );
	}

	/**
	 * Updates an existing address
	 * @param WP_REST_Request $request Request data
	 * @param AddressInterface|null $address Address to update
	 * @return \WP_REST_Response
	 */
	public function update(
		\WP_REST_Request $request, AddressInterface $address = null
	): \WP_REST_Response {
		$status;
		if ( $address ) {
			$params = $request->get_params();
			$params = $this->remap_parameters( $params );
			$this->address_repository->update( $address, $params );
			$status = 'Successfully updated the address!';
		} else {
			$status = 'Failed to update the address!';
		}
		return new \WP_REST_Response( array(
			'status' => $status,
		) );
	}

	/**
	 * Verifies an existing address
	 * @param WP_REST_Request $request Request data
	 * @param AddressInterface|null $address Address to verify
	 * @return \WP_REST_Response
	 */
	public function verify(
		\WP_REST_Request $request, AddressInterface $address = null
	): \WP_REST_Response {
		if ( $address ) {
			$params = $request->get_params();
			$params = $this->remap_parameters( $params );
			$this->address_repository->verify( $address, $params );
			$status = 'Successfully verified the address!';
		} else {
			$status = 'Failed to verify the address!';
		}
		return new \WP_REST_Response( array(
			'status' => $status,
		) );
	}

	/**
	 * Deletes a address
	 * @param WP_REST_Request $request Request data
	 * @param AddressInterface|null $address Bound address
	 * @return \WP_REST_Response
	 */
	public function destroy(
		\WP_REST_Request $request, AddressInterface $address = null
	): \WP_REST_Response {
		if ( $address ) {
			$params = $request->get_params();
			$params = $this->remap_parameters( $params );
			$this->address_repository->destroy( $address, $params );
			$status = 'Successfully deleted the address!';
		} else {
			$status = 'Failed to delete the address!';
		}
		return new \WP_REST_Response( array(
			'status' => $status,
		) );
	}

	/**
	 * Gets a collection of balance
	 * @param \WP_REST_Request $request Request data
	 * @param AddressInterface $user Bound address
	 * @return \WP_REST_Response
	 */
	public function balance_index(
		\WP_REST_Request $request, AddressInterface $address = null
	): \WP_REST_Response {
		$balance = array();
		if ( $address ) {
			$this->address_repository->load( $address, array( 'balance.meta' ) );
			if ( $address->balance ) {
				$balance = $address->balance->to_array();
			}
		}
		return new \WP_REST_Response( $balance );
	}

	protected function remap_parameters( array $params = array() ): array {
		$user = $this->user_repository->show_current();
		if ( $user ) {
			$params['oauth_token'] = $user->oauth_token;
		}
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
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->address_repository,
			'single_methods'            => array(
				'show', 'update', 'destroy', 'verify', 'balance_index'
			),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
