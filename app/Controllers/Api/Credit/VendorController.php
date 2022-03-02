<?php

namespace Tokenly\Wp\Controllers\Api\Credit;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\VendorControllerInterface;

use Tokenly\Wp\Interfaces\Services\Application\Credit\VendorServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines transaction endpoints
 */
class VendorController extends Controller implements VendorControllerInterface {
	protected VendorServiceInterface $vendor_service;

	public function __construct(
		VendorServiceInterface $vendor_service,
		UserRepositoryInterface $user_repository
	) {
		$this->vendor_service = $vendor_service;
		$this->user_repository = $user_repository;
	}

	/**
	 * Makes a new debit transaction
	 * @param \WP_REST_Request $request Request data
	 * @return array|null
	 */
	public function debit( \WP_REST_Request $request ): ?array {
		$params = $request->get_params();
		$group = null;
		if ( isset( $params['group_uuid'] ) ) {
			$group = $params['group_uuid'];
		};
		$account = null;
		if ( isset( $params['account'] ) ) {
			$account = $this->get_account_by_username( $params['account'] );
		};
		$amount = null;
		if ( isset( $params['amount'] ) ) {
			$amount = floatval( $params['amount'] );
		};
		$ref = null;
		if ( isset( $params['ref'] ) ) {
			$ref = $params['ref'];
		};
		$source = null;
		if ( isset( $params['source'] ) ) {
			$source = $params['source'];
		};
		$transactions = $this->vendor_service->debit( $group, $account, $amount, $ref, $source );
		if ( $transactions ) {
			$transactions = $transactions->to_array();
		}
		return $transactions;
	}

	/**
	 * Makes a new credit transaction
	 * @param \WP_REST_Request $request Request data
	 * @return array|null
	 */
	public function credit( \WP_REST_Request $request ): ?array {
		$params = $request->get_params();
		$group = null;
		if ( isset( $params['group_uuid'] ) ) {
			$group = $params['group_uuid'];
		};
		$account = null;
		if ( isset( $params['account'] ) ) {
			$account = $this->get_account_by_username( $params['account'] );
		};
		$amount = null;
		if ( isset( $params['amount'] ) ) {
			$amount = floatval( $params['amount'] );
		};
		$ref = null;
		if ( isset( $params['ref'] ) ) {
			$ref = $params['ref'];
		};
		$source = null;
		if ( isset( $params['source'] ) ) {
			$source = $params['source'];
		};
		$transactions = $this->vendor_service->credit( $group, $account, $amount, $ref, $source );
		if ( $transactions ) {
			$transactions = $transactions->to_array();
		}
		return $transactions;
	}

	protected function get_account_by_username( string $account ): ?string {
		$user = $this->user_repository->show( array(
			'name' => $account,
			'with' => array(
				'oauth_user',
			),
		) );
		if ( $user ) {
			return $user->get_uuid();
		}
		return null;
	}

	protected function remap_parameters( array $params = array() ): array {
		return $params;
	}
}
