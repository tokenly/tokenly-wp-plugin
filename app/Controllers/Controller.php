<?php

namespace Tokenly\Wp\Controllers;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

class Controller implements ControllerInterface {
	protected $defaults = array(
		'service'                   => null,
		'query_parameter'           => null,
		'single_service_parameter'  => null,
		'single_service_method'     => null,
		'single_methods'            => array(),
		'collection_methods'        => array(),
		'collection_service_method' => null,
	);

	/**
	 * Gets model binding parameters
	 * @return array Binding parameters
	 */
	protected function get_bind_params() {
		return array();
	}

	/**
	 * Remaps request parameters for use with the domain service
	 * @param array $params Request parameters
	 * @return array
	 */
	protected function remap_parameters( array $params ) {
		return $params;
	}
	
	/**
	 * Gets the bound model / collection
	 * @param \WP_REST_Request $request Request data
	 * @return GroupInterface Bound model
	 */
	public function bind( \WP_REST_Request $request, string $method ) {
		$service_method;
		$params = $request->get_params();
		$params = $this->remap_parameters( $params );
		$bind_params = array_merge( $this->defaults, $this->get_bind_params() );
		if ( in_array( $method, $bind_params['single_methods'] ) ) {
			$service_method = $bind_params['single_service_method'];
		} elseif ( in_array( $method, $bind_params['collection_methods'] ) ) {
			$service_method = $bind_params['collection_service_method'];
		}
		if ( isset( $params['with'] ) && is_string( $params['with'] ) ) {
			$params['with'] = explode( ',', $params['with'] );
		}
		$service = $bind_params['service'];
		return call_user_func( array( $service, $service_method ), $params );
	}
}
