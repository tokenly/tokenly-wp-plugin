<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;

/**
 * Defines promise-related endpoints
 */
class PromiseController implements PromiseControllerInterface {
	protected $promise_service;
	protected $user_repository;

	public function __construct(
		PromiseServiceInterface $promise_service
	) {
		$this->promise_service = $promise_service;
	}
	
	/**
	 * Get a list of current promises
	 * @param \WP_REST_Request $request Request data
	 * @return PromiseInterface[]
	 */
	public function index( \WP_REST_Request $request ) {
		$promises = $this->promise_service->index();
		return $promises;
	}

	/**
	 * Creates a new promise
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$promise = $this->promise_service->store( $params );
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
	public function update( \WP_REST_Request $request ) {
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
	public function destroy( \WP_REST_Request $request ) {
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
	protected function get_promise( \WP_REST_Request $request ) {
		$promise_id = $request->get_param( 'promise' );
		if ( !$promise_id ) {
			return;
		}
		$promise = $this->promise_service->show( $promise_id );
		return $promise;
	}
}
