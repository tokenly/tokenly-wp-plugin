<?php

namespace Tokenly\Wp\Controllers;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

class Controller implements ControllerInterface {
	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => null,
			'query_parameter'           => null,
			'single_service_parameter'  => null,
			'single_service_method'     => null,
			'single_methods'            => null,
			'collection_methods'        => null,
			'collection_service_method' => null,
		);
	}

	protected function remap_parameters( array $params ) {
		return $params;
	}
	
	/**
	 * Gets the bound model / collection
	 * @param \WP_REST_Request $request Request data
	 * @return GroupInterface
	 */
	public function bind( \WP_REST_Request $request, string $method ) {
		$service_method;
		$params = $request->get_params();
		$params = $this->remap_parameters( $params );
		$callable_params = $params;
		$bind_params = $this->get_bind_params();
		if ( in_array( $method, $bind_params['single_methods'] ) ) {
			$service_method = $bind_params['single_service_method'];
			$callable_params = array(
				$bind_params['single_service_parameter'] => $params[ $bind_params['query_parameter'] ],
			);
		} elseif ( in_array( $method, $bind_params['collection_methods'] ) ) {
			$service_method = $bind_params['collection_service_method'];
		}
		if ( isset( $params['with'] ) && is_string( $params['with'] ) ) {
			$callable_params['with'] = explode( ',', $params['with'] );
		}
		$service = $bind_params['service'];
		return call_user_func( array( $service, $service_method ), $callable_params );
	}
}
