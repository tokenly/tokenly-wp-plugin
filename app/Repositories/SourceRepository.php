<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository implements SourceRepositoryInterface {
	protected $client;
	protected $source_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		SourceCollectionFactoryInterface $source_collection_factory
	) {
		$this->client = $client;
		$this->source_collection_factory = $source_collection_factory;
	}

	/**
	 * Gets the source data by address
	 * @param string $address Source address
	 * @return array
	 */
	public function show( array $params = array() ) {
		if ( isset( $params['address'] ) === false ) {
			return;
		}
		$address = $params['address'];
		$sources = $this->index();
		$source = $sources[ $address ] ?? null;
		return $source;
	}

	/**
	 * Gets the list of registered source addresses
	 * @return array
	 */
	public function index( array $params = array() ) {
		$sources = $this->client->getProvisionalSourceList();
		if ( $sources == false ) {
			return false;
		}
		$sources = $this->source_collection_factory->create( $sources );
		return $sources;
	}
	
	/**
	 * Registers the source address for the current integration
	 * @param array $source New source address data
	 * @return boolean
	 */
	public function store( array $params = array() ) {
		$source = $this->client->registerProvisionalSource(
			$params['address'] ?? null,
			$params['type'] ?? null,
			$params['proof'] ?? null,
			$params['assets'] ?? null,
		);
		$source = $this->source_factory->create( $source );
		return $source;
	}

	/**
	 * Updates the exisiting source by address
	 * @param SourceInterface $source Source to update
	 * @param array $params New source data
	 * @return SourceInterface
	 */
	public function update( SourceInterface $source, array $params ) {
		$params['address'] = $source->address;
		return $this->store( $params );
	}

	/**
	 * Destroys the existing source
	 * @param SourceInterface $source Source to destroy
	 * @return void
	 */
	public function destroy( SourceInterface $source ) {
		$this->client->deleteProvisionalSource( $source->address );
	}
}
