<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;

/**
 * Defines promise-related endpoints
 */
class CreditGroupController implements CreditGroupControllerInterface {
	protected $credit_group_service;

	public function __construct(
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_service = $credit_group_service;
	}
	
	/**
	 * Retrieves a collection of credit groups
	 * @param \WP_REST_Request $request Request data
	 * @return CreditGroupCollectionInterface
	 */
	public function index( \WP_REST_Request $request ) {
		$credit_groups = $this->credit_group_service->index();
		$credit_groups = $credit_groups->to_array();
		return $credit_groups;
	}

	/**
	 * Creates a new credit group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function store( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$credit_group = $this->credit_group_service->store( $params );
		return array(
			'credit_group' => $credit_group,
			'status'  => 'Credit group created successfully',
		);
	}

	/**
	 * Updates an existing credit group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function update( \WP_REST_Request $request ) {
		$credit_group_id = $request->get_param( 'uuid' );
		$credit_group = $this->credit_group_service->show( array(
			'group_uuid' => $credit_group_id,
		) );
		if ( !$credit_group_id ) {
			return;
		}
		$params = $request->get_params();
		$credit_group->update( $params );
		return array(
			'status' => 'Credit group successfully updated!',
		);
	}

	/**
	 * Destroys an existing credit group
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( \WP_REST_Request $request ) {
		$credit_group = $this->get_credit_group( $request );
		if ( !$credit_group ) {
			return;
		}
		$credit_group->destroy();
		return array(
			'status' => "Credit group successfully cancelled!",
		);
	}
	
	/**
	 * Retrieves queried credit group
	 * @param \WP_REST_Request $request Request data
	 * @return PromiseInterface
	 */
	protected function get_credit_group( \WP_REST_Request $request ) {
		$credit_group_id = $request->get_param( 'credit_group' );
		if ( !$credit_group_id ) {
			return;
		}
		$credit_group = $this->credit_group_service->show( array(
			'group_uuid' => $credit_group_id,
		) );
		return $credit_group;
	}
}
