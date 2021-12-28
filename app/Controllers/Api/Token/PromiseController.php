<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;

/**
 * Defines promise-related endpoints
 */
class PromiseController extends Controller implements PromiseControllerInterface {
	protected $promise_service;
	protected $user_repository;

	public function __construct(
		PromiseServiceInterface $promise_service
	) {
		$this->promise_service = $promise_service;
	}
	
	/**
	 * Gets a collection of promises
	 * @param PromiseCollectionInterface $promises Bound promises
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( PromiseCollectionInterface $promises, \WP_REST_Request $request ) {
		$promises = $promises->to_array();
		return $promises;
	}

	/**
	 * Gets a single promise
	 * @param PromiseInterface $promise Bound model
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( PromiseInterface $promise, \WP_REST_Request $request ) {
		$promise = $promise->to_array();
		return $promise;
	}

	/**
	 * Makes a new promise
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
	public function update( PromiseInterface $promise, \WP_REST_Request $request ) {
		$params = $request->get_params();
		$promise->update( $params );
		return array(
			'status' => 'Promise successfully updated!',
		);
	}

	/**
	 * Deletes a promise
	 * @param PromiseInterface $promise Bound promise
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( PromiseInterface $promise, \WP_REST_Request $request ) {
		$promise->destroy();
		return array(
			'status' => "Promise successfully cancelled!",
		);
	}

	protected function remap_parameters( array $params = array() ) {
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
	protected function get_bind_params() {
		return array(
			'service'                   => $this->promise_service,
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
