<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

/**
 * Manages the sources
 */
class SourceService extends DomainService implements SourceServiceInterface {
	protected $source_repository;

	public function __construct(
		SourceRepositoryInterface $source_repository
	) {
		$this->source_repository = $source_repository;
	}

	/**
	 * Gets a collection of sources
	 * @param array $params Search parameters
	 * @return SourceCollectionInterface
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single source
	 * @param string $params Search parameters
	 * @return SourceInterface
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}
	
	/**
	 * Registers the source address for the current integration
	 * @param array $source New source address data
	 * @return SourceInterface
	 */
	public function store( array $params ) {
		if (
			!isset( $params['address'] ) ||
			!isset( $params['type'] )
		) {
			return;
		}
		$address = $params['address'] ?? null;
		$proof = $this->make_proof( $address );
		$type = $params['type'];
		$assets = $params['assets'] ?? null;
		if ( empty( $assets ) ) {
			$assets = null;
		}
		$source = $this->source_repository->store( array(
			'address' => $address,
			'type'    => $type,
			'proof'   => $proof,
			'assets'  => $assets,
		) );
		return $source;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return SourceCollectionInterface
	 */
	protected function index_cacheable( array $params = array() ) {	
		$sources = $this->source_repository->index( $params );
		return $sources;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param string $params Search parameters
	 * @return SourceInterface
	 */
	protected function show_cacheable( array $params = array() ) {
		$source = $this->source_repository->show( $params );
		return $source;
	}

	/**
	 * Makes a proof for source storage
	 * @param string $address Address to use for making a proof
	 * @return string
	 */
	protected function make_proof( string $address ) {
		if ( !isset( $this->settings->client_id ) ) {
			return;
		}
		$hash = hash( 'sha256', $this->settings_client_id );
		$proof =  "{$address}_{$hash}";
		return $proof;
	}
}
