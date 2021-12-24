<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

/**
 * Handles the source REST API endpoints
 */
class SourceController implements SourceControllerInterface {
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	/**
	 * Responds with registered sources
	 * @param \WP_REST_Request $request Request data
	 * @return Source[]
	 */
	public function index( \WP_REST_Request $request ) {
		$params = $request->get_params();
		if ( isset( $params['with'] ) && is_string( $params['with'] ) ) {
			$params['with'] = explode( ',', $params['with'] );
		}
		$sources = $this->source_service->index( $params );
		$sources = clone $sources;
		$sources->key_by_field( 'address_id' );
		$sources = $sources->to_array();
		return $sources;
	}

	/**
	 * Creates a new source
	 * @param \WP_REST_Request $request Request data
	 * @return Source
	 */
	public function store( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$this->source_service->store( $params );
		return array(
			'status' => "Source successfully created!",
		);
	}

	/**
	 * Updates a registered source
	 * @param \WP_REST_Request $request Request data
	 * @return Source 
	 */
	public function update( \WP_REST_Request $request ) {
		$params = $request->get_params();
		$address = $params['address'] ?? null;
		if ( !$address ) {
			return array(
				'status' => "Not updated. No address supplied.",
			);
		}
		$source = $this->source_service->show( array( 'address' => $address ) );
		if ( !$source ) {
			return array(
				'status' => "Not updated. Source not found.",
			);
		}
		$source->update( $params );
		return array(
			'status' => "Source successfully updated!",
		);
	}

	/**
	 * Destroys a registered source
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( \WP_REST_Request $request ) {
		$address = $request->get_param( 'address' );
		if ( !$address ) {
			return array(
				'status' => "Not destroyed. No address supplied.",
			);
		}
		$source = $this->source_service->show( array( 'address' => $address ) );
		if ( !$source ) {
			return array(
				'status' => "Not destroyed. Address not found.",
			);
		}
		$source->destroy();
		return array(
			'status' => "Source successfully destroyed!",
		);
	}
}
