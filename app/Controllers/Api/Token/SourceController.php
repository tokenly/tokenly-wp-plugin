<?php

namespace Tokenly\Wp\Controllers\Api\Token;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Defines source endpoints
 */
class SourceController extends Controller implements SourceControllerInterface {
	protected SourceRepositoryInterface $source_repository;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		SourceRepositoryInterface $source_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->source_repository = $source_repository;
		$this->user_repository = $user_repository;
	}
	
	/**
	 * Responds with registered sources
	 * @param \WP_REST_Request $request Request data
	 * @param SourceCollectionInterface $sources Bound sources
	 * @return \WP_REST_Response
	 */
	public function index( \WP_REST_Request $request, SourceCollectionInterface $sources ): \WP_REST_Response {
		$sources = clone $sources;
		$sources->key_by_field( 'address_id' );
		$sources = $sources->to_array();
		return new \WP_REST_Response( $sources );
	}

	/**
	 * Gets a single source
	 * @param \WP_REST_Request $request Request data
	 * @param SourceInterface|null $source Bound source
	 * @return \WP_REST_Response
	 */
	public function show( \WP_REST_Request $request, SourceInterface $source = null ): \WP_REST_Response {
		if ( $source ) {
			$source = $source->to_array();
		}
		return new \WP_REST_Response( $source );
	}

	/**
	 * Creates a new source
	 * @param \WP_REST_Request $request Request data
	 * @return \WP_REST_Response
	 */
	public function store( \WP_REST_Request $request ): \WP_REST_Response {
		$params = $request->get_params();
		$source = $this->source_repository->store( $params );
		return new \WP_REST_Response();
	}

	/**
	 * Updates the source
	 * @param \WP_REST_Request $request Request data
	 * @param SourceInterface|null $source Bound source
	 * @return \WP_REST_Response 
	 */
	public function update( \WP_REST_Request $request, SourceInterface $source = null ): \WP_REST_Response {
		if ( $source ) {
			$params = $request->get_params();
			$this->source_repository->update( $source, $params );
		}
		return new \WP_REST_Response();
	}

	/**
	 * Deletes the source
	 * @param \WP_REST_Request $request Request data
	 * @param SourceInterface|null $source Bound source
	 * @return \WP_REST_Response
	 */
	public function destroy( \WP_REST_Request $request, SourceInterface $source = null ): \WP_REST_Response {
		if ( $source ) {
			$this->source_repository->destroy( $source );
		}
		return new \WP_REST_Response();
	}

	protected function remap_parameters( array $params = array() ): array {
		$user = $this->user_repository->show_current();
		if ( $user ) {
			$params['oauth_token'] = $user->get_oauth_token();
		}
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
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->source_repository,
			'single_service_method'     => 'show',
			'single_methods'            => array( 'show', 'update', 'destroy' ),
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
