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
	 * @param \WP_REST_Request $request Request data
	 * @param PromiseCollectionInterface $promises Bound promises
	 * @return array
	 */
	public function index( \WP_REST_Request $request, PromiseCollectionInterface $promises ): array {
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
	 * @param \WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Bound model
	 * @return array|null
	 */
	public function show( \WP_REST_Request $request, PromiseInterface $promise = null ): ?array {
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
	public function store( \WP_REST_Request $request ): ?array {
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
	 * @param WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Promise to update
	 * @return array
	 */
	public function update( \WP_REST_Request $request, PromiseInterface $promise = null ): void {
		if ( $promise ) {
			$params = $request->get_params();
			$this->promise_repository->update( $promise, $params );
		}
	}

	/**
	 * Deletes a promise
	 * @param WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Bound promise
	 * @return array
	 */
	public function destroy( \WP_REST_Request $request, PromiseInterface $promise = null ): void {
		if ( $promise ) {
			$this->promise_repository->destroy( $promise );
		}
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
