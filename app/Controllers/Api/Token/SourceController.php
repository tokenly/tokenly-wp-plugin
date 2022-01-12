<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

/**
 * Defines source endpoints
 */
class SourceController extends Controller implements SourceControllerInterface {
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	/**
	 * Responds with registered sources
	 * @param SourceCollectionInterface $sources Bound sources
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( SourceCollectionInterface $sources, \WP_REST_Request $request ) {
		$sources = clone $sources;
		$sources->key_by_field( 'address_id' );
		$sources = $sources->to_array();
		return $sources;
	}

	/**
	 * Gets a single source
	 * @param SourceInterface $source Bound source
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function show( SourceInterface $source, \WP_REST_Request $request ) {
		$source = $source->to_array();
		return $source;
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
	 * Updates the source
	 * @param SourceInterface $source Bound source
	 * @param \WP_REST_Request $request Request data
	 * @return Source 
	 */
	public function update( SourceInterface $source, \WP_REST_Request $request ) {
		$params = $request->get_params();
		$source->update( $params );
		return array(
			'status' => "Source successfully updated!",
		);
	}

	/**
	 * Deletes the source
	 * @param SourceInterface $source Bound source
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function destroy( SourceInterface $source, \WP_REST_Request $request ) {
		$source->destroy();
		return array(
			'status' => "Source successfully destroyed!",
		);
	}

	protected function remap_parameters( array $params = array() ) {
		if ( isset( $params['source'] ) ) {
			$params['address'] = $params['source'];
			unset( $params['source'] );
		}
		return $params;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->source_service,
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
