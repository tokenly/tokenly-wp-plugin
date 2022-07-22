<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;

use Tokenly\Wp\Collections\Token\SourceCollection;
use Tokenly\Wp\Models\Token\Source;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository extends Repository implements SourceRepositoryInterface {
	protected TokenpassAPIInterface $client;
	protected IntegrationSettingsInterface $integration_settings;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected AddressRepositoryInterface $address_repository;

	public function __construct(
		TokenpassAPIInterface $client,
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		AddressRepositoryInterface $address_repository
	) {
		$this->integration_settings_repository 
			= $integration_settings_repository;
		$this->integration_settings =
			$this->integration_settings_repository->show();
		$this->address_repository = $address_repository;
		$this->client = $client;
	}

	/**
	 * Gets a collection of sources
	 * @param array $params Search parameters
	 * @return SourceCollectionInterface
	 */
	public function index(
		array $params = array()
	): SourceCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single source
	 * @param string $params Search parameters
	 * @return SourceInterface|null
	 */
	public function show( array $params = array() ): ?SourceInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}
	
	/**
	 * Registers the source address for the current integration
	 * @param array $source New source address data
	 * @return bool
	 */
	public function store( array $params ): bool {
		if (
			!isset( $params['address'] ) ||
			!isset( $params['type'] )
		) {
			return false;
		}
		$address = $params['address'] ?? null;
		$proof = $this->make_proof( $address );
		$type = $params['type'];
		$assets = $params['assets'] ?? null;
		$result = $this->client->registerProvisionalSource(
			$address, $type, $proof, $assets );
		return $result;
	}

	/**
	 * Updates the exisiting source by address
	 * @param SourceInterface $source Source to update
	 * @param array $params New source data
	 * @return bool
	 */
	public function update( SourceInterface $source, array $params ): bool {
		if ( isset( $params['assets'] ) ) {
			if ( is_array( $params['assets'] ) ) {
				$params['assets'] = array_filter( $params['assets'] );
			}
			if ( empty( $params['assets'] ) ) {
				$params['assets'] = null;
			}
		}
		$params['address'] = $source->address_id;
		$params['type'] = $source->type;
		return $this->store( $params );
	}

	/**
	 * Destroys the existing source
	 * @param SourceInterface $source Source to destroy
	 * @return void
	 */
	public function destroy( SourceInterface $source ): void {
		$this->client->deleteProvisionalSource( $source->address_id );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return SourceCollectionInterface
	 */
	protected function index_cacheable(
		array $params = array()
	): SourceCollectionInterface {	
		$sources = $this->client->getProvisionalSourceList();
		if ( $sources && is_array( $sources ) ) {
			foreach ( $sources as &$source ) {
				$source = $this->remap_fields( $source );
			}
		} else {
			$sources = array();
		}
		$sources = ( new SourceCollection() )->from_array( $sources );
		return $sources;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param string $params Search parameters
	 * @return SourceInterface|null
	 */
	protected function show_cacheable(
		array $params = array()
	): ?SourceInterface {
		if ( isset( $params['address'] ) === false ) {
			return null;
		}
		$address = $params['address'];
		$sources = $this->index( $params );
		$sources = clone $sources->key_by_field( 'address_id' );
		if ( isset( $sources[ $address ] ) ) {
			return $sources[ $address ];
		}
		return null;
	}

	/**
	 * Makes a proof for source storage
	 * @param string $address Address to use for making a proof
	 * @return string
	 */
	protected function make_proof( string $address ): string {
		$hash = hash( 'sha256', $this->integration_settings->client_id );
		$proof =  "{$address}_{$hash}";
		return $proof;
	}

	protected function remap_fields( array $source ): array {
		$source['address_id'] = $source['address'];
		unset( $source['address'] );
		return $source; 
	}

	/**
	 * Loads the address relation
	 * @param array $relations Further relations
	 * @return AddressInterface 
	 */
	protected function load_address(
		SourceInterface $source,
		array $relations = array(),
		?array $params = array()
	): ?AddressInterface {
		$params = array_merge( array(
			'address'     => $source->address_id,
			'with'        => $relations,
		), $params );
		$address = $this->address_repository->show( $params );
		return $address;
	}
}
