<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

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
	 * @param array $request Request data
	 * @return Source[]
	 */
	public function index( $request ) {
		$sources = $this->source_service->index();
		return $sources;
	}

	/**
	 * Creates a new source
	 * @param WP_REST_Request $request Request data
	 * @return Source
	 */
	public function store( $request ) {
		$params = $request->get_params();
		$source = $this->source_service->store( $params );
		return $source;
	}

	/**
	 * Updates a registered source
	 * @param WP_REST_Request $request Request data
	 * @return Source 
	 */
	public function update( $request ) {
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
		$source = $source->update( $params );
		return $source;
	}

	/**
	 * Destroys a registered source
	 * @param WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( $request ) {
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
			'status' => "Address successfully destroyed!",
		);
	}
}
