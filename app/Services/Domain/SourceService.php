<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;

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
	 * Gets the list of registered source addresses
	 * @return array
	 */
	protected function _index( array $params = array() ) {	
		$sources = $this->source_repository->index();
		return $sources;
	}

	/**
	 * Gets the source data by address
	 * @param string $address Source address
	 * @return SourceInterface
	 */
	protected function _show( array $params = array() ) {
		$source = $this->source_repository->show( $params );
		return $source;
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
		$source = $this->source_repository->store( $address, $type, $proof, $assets );
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
