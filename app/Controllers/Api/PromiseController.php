<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines promise-related endpoints
 */
class PromiseController implements PromiseControllerInterface {
	protected $promise_repository;
	protected $user_repository;

	public function __construct(
		PromiseRepositoryInterface $promise_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->promise_repository = $promise_repository;
		$this->user_repository = $user_repository;
	}
	
	/**
	 * Get a list of current promises
	 * @param WP_REST_Request $request Request data
	 * @return PromiseInterface[]
	 */
	public function index( $request ) {
		$promises = $this->promise_repository->index();
		return $promises;
	}

	/**
	 * Creates a new promise
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( $request ) {
		$params = $request->get_params();
		$promise = $this->promise_repository->store( $params );
		return array(
			'promise' => $promise,
			'status'  => 'Promise created successfully',
		);
	}

	/**
	 * Updates an existing promise
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( $request ) {
		$promise = $this->get_promise( $request );
		if ( !$promise ) {
			return;
		}
		$params = $request->get_params();
		$promise->update( $params );
		return array(
			'status' => 'Promise successfully updated!',
		);
	}

	/**
	 * Destroys an existing promise
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( $request ) {
		$promise = $this->get_promise( $request );
		if ( !$promise ) {
			return;
		}
		$promise->destroy();
		return array(
			'status' => "Promise successfully cancelled!",
		);
	}
	
	/**
	 * Retrieves queried promise
	 * @param WP_REST_Request $request Request data
	 * @return PromiseInterface
	 */
	protected function get_promise( $request ) {
		$promise_id = $request->get_param( 'promise' );
		if ( !$promise_id ) {
			return;
		}
		$promise = $this->promise_repository->show( $promise_id );
		return $promise;
	}
}
