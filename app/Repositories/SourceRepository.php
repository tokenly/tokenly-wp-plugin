<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\SourceFactoryInterface;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository implements SourceRepositoryInterface {
	protected $client;
	
	public function __construct(
		TokenpassAPIInterface $client,
		SettingsInterface $settings,
		SourceFactoryInterface $source_factory
	) {
		$this->client = $client;
		$this->settings = $settings;
		$this->source_factory = $source_factory;
	}

	/**
	 * Gets the source data by address
	 * @param string $address Source address
	 * @return array
	 */
	public function show( $address ) {
		$sources = $this->index();
		$source = $sources[ $address ] ?? null;
		return $source;
	}

	/**
	 * Gets the list of registered source addresses
	 * @return array
	 */
	public function index() {
		$sources = $this->client->getProvisionalSourceList();
		$sources = array_map( function( $source ) {
			return $this->source_factory->create( $source );
		}, $sources );
		return $sources;
	}
	
	/**
	 * Registers the source address for the current integration
	 * @param array $source New source address data
	 * @return boolean
	 */
	public function store( $source ) {
		$client_id = $this->settings->client_id ?? null;
		$hash = hash( 'sha256', $client_id );
		$address = $source['address'] ?? null;
		$type = $source['type'] ?? null;
		$proof =  $address . '_' . $hash;
		$assets = $source['assets'] ?? null;
		if ( empty( $assets ) ) {
			$assets = null;
		}
		try {
			$this->client->registerProvisionalSource( $address, $type, $proof, $assets );
			return true;
		}
		catch ( exception $e ) {
			return false;
		}
	}

	/**
	 * Updates the exisiting source by address
	 * @param string $address Address of source
	 * @param array $params New source data
	 * @return boolean
	 */
	public function update( $address, $params ) {
		return $this->store( $params );
	}

	/**
	 * Destroys the existing source by address
	 * @param string $address
	 * @return void
	 */
	public function destroy( $address ) {
		$this->client->deleteProvisionalSource( $address );
	}
}
