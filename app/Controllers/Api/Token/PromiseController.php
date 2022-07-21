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
class PromiseController extends Controller
	implements PromiseControllerInterface
{
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
	 * @return \WP_REST_Response
	 */
	public function index(
		\WP_REST_Request $request, PromiseCollectionInterface $promises
	): \WP_REST_Response {
		$promises = $this->promise_repository->load(
			$promises,
			array( 'promise_meta' )
		);
		$users = $promises->users;
		$users = $this->user_repository->index( array(
			'uuids' => $users,
		) );
		$promises = $promises->embed_users( $users );
		return new \WP_REST_Response( array(
			'promises' => $promises,
		) );
	}

	/**
	 * Gets a single promise
	 * @param \WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Bound model
	 * @return \WP_REST_Response
	 */
	public function show(
		\WP_REST_Request $request, ?PromiseInterface $promise = null
	): \WP_REST_Response {
		if ( $promise ) {
			$this->promise_repository->load(
				$promise,
				array( 'promise_meta' )
			);
			$promise = $promise->to_array();
			if ( !isset( $promise['promise_meta'] ) ) {
				return $promise;
			}
			$meta = $promise['promise_meta'];
			$destination = $meta['destination_user_id'];
			$source = $meta['source_user_id'];
			$users = $this->user_repository->index( array(
				'ids' => array( $source, $destination ),
			) );
			$users = clone $users;
			$users->key_by_field( 'uuid' );
			$users = $users->to_array();
			$meta['destination_user'] = $users[ $destination ] ?? null;
			$meta['source_user'] = $users[ $source ] ?? null;
			$promise['promise_meta'] = $meta;
		}
		return new \WP_REST_Response( $promise );
	}

	/**
	 * Makes a new promise
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function store( \WP_REST_Request $request ): \WP_REST_Response {
		$params = $request->get_params();
		$promise = $this->promise_repository->store( $params );
		if ( $promise ) {
			$status = 'Successfully created a promise!';
		} else {
			$status = 'Failed to create a promise!';
		}
		return new \WP_REST_Response( array(
			'promise' => $promise,
			'status'  => $status,
		) );
	}

	/**
	 * Updates an existing promise
	 * @param WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Promise to update
	 * @return \WP_REST_Response
	 */
	public function update(
		\WP_REST_Request $request, PromiseInterface $promise = null
	): \WP_REST_Response {
		if ( $promise ) {
			$params = $request->get_params();
			$this->promise_repository->update( $promise, $params );
		}
		return new \WP_REST_Response( $promise );
	}

	/**
	 * Deletes a promise
	 * @param WP_REST_Request $request Request data
	 * @param PromiseInterface|null $promise Bound promise
	 * @return \WP_REST_Response
	 */
	public function destroy(
		\WP_REST_Request $request, PromiseInterface $promise = null
	): \WP_REST_Response {
		if ( $promise ) {
			$this->promise_repository->destroy( $promise );
		}
		return new \WP_REST_Response();
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
			'single_methods'            => array(
				'show', 'update', 'destroy'
			),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
