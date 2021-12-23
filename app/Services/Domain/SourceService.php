<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

/**
 * Manages the sources
 */
class SourceService extends DomainService implements SourceServiceInterface {
	protected $source_repository;
	protected $integration_settings;

	public function __construct(
		SourceRepositoryInterface $source_repository,
		IntegrationSettingsInterface $integration_settings
	) {
		$this->source_repository = $source_repository;
		$this->integration_settings = $integration_settings;
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
		error_log(d( $proof ));
		$source = $this->source_repository->store( array(
			'address' => $address,
			'type'    => $type,
			'proof'   => $proof,
			'assets'  => $assets,
		) );
		return $source;
	}

	/**
	 * Makes a proof for source storage
	 * @param string $address Address to use for making a proof
	 * @return string
	 */
	protected function make_proof( string $address ) {
		$hash = hash( 'sha256', $this->integration_settings->client_id );
		$proof =  "{$address}_{$hash}";
		return $proof;
	}
}
