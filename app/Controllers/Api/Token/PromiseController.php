<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface;

use Tokenly\Wp\Collections\Token\PromiseMetaCollection;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines promise endpoints
 */
class PromiseController extends Controller implements PromiseControllerInterface {
	protected PromiseRepositoryInterface $promise_repository;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		PromiseRepositoryInterface $promise_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->promise_repository = $promise_repository;
		$this->user_repository = $user_repository;
	}
	
	/**
	 * Gets a collection of promises
	 * @param PromiseCollectionInterface $promises Bound promises
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( PromiseCollectionInterface $promises, \WP_REST_Request $request ): array {
		$promises = $this->promise_repository->load( $promises, array( 'promise_meta' ) );
		$users = $promises->get_users();
		$users = $this->user_repository->index( array(
			'uuids' => $users,
		) );
		$promises = $promises->embed_users( $users );
		return array(
			'promises' => $promises,
		);
	}

	/**
	 * Gets a single promise
	 * @param PromiseInterface|null $promise Bound model
	 * @param \WP_REST_Request $request Request data
	 * @return array|null
	 */
	public function show( PromiseInterface $promise = null, \WP_REST_Request $request ): ?array {
		if ( $promise ) {
			$promise = $promise->to_array();
		}
		return $promise;
	}

	/**
	 * Makes a new promise
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ): array {
		$params = $request->get_params();
		$promise = $this->promise_repository->store( $params );
		if ( $promise ) {
			return array(
				'promise' => $promise,
				'status'  => 'Successfully created a promise!',
			);
		}
		return array(
			'promise' => null,
			'status'  => 'Failed to create a promise!',
		);
	}

	/**
	 * Updates an existing promise
	 * @param PromiseInterface|null $promise Promise to update
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( PromiseInterface $promise = null, \WP_REST_Request $request ) {
		if ( $promise ) {
			$params = $request->get_params();
			$this->promise_repository->update( $promise, $params );
			return array(
				'status' => 'Successfully updated the promise!',
			);
		}
		return array(
			'status' => 'Failed to update the promise!',
		);
	}

	/**
	 * Deletes a promise
	 * @param PromiseInterface|null $promise Bound promise
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( PromiseInterface $promise = null, \WP_REST_Request $request ) {
		if ( $promise ) {
			$this->promise_repository->destroy( $promise );
			return array(
				'status' => 'Successfully deleted the promise!',
			);
		}
		return array(
			'status' => 'Failed to delete the promise!',
		);
	}

	protected function remap_parameters( array $params = array() ): array {
		if ( isset( $params['promise'] ) ) {
			$params['promise_id'] = $params['promise'];
			unset( $params['promise'] );
		}
		return $params;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->promise_repository,
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
