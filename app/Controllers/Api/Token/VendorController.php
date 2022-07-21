<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\VendorControllerInterface;

use Tokenly\Wp\Interfaces\Services\Application\Token\VendorServiceInterface;

/**
 * Defines transaction endpoints
 */
class VendorController extends Controller
	implements VendorControllerInterface
{
	protected VendorServiceInterface $vendor_service;

	public function __construct(
		VendorServiceInterface $vendor_service
	) {
		$this->vendor_service = $vendor_service;
	}

	/**
	 * Makes a new promise
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function promise( \WP_REST_Request $request ): \WP_REST_Response {
		$params = $request->get_params();
		$promise = $this->vendor_service->promise( $params );
		if ( $promise ) {
			$promise = $promise->to_array();
		}
		return new \WP_REST_Response( $promise );
	}

	protected function remap_parameters( array $params = array() ): array {
		return $params;
	}
}
