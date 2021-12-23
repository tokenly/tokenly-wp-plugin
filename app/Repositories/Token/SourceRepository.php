<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;

use Tokenly\Wp\Interfaces\Factories\Collections\Token\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\SourceFactoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository implements SourceRepositoryInterface {
	protected $client;
	protected $source_factory;
	protected $source_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		SourceFactoryInterface $source_factory,
		SourceCollectionFactoryInterface $source_collection_factory
	) {
		$this->client = $client;
		$this->source_collection_factory = $source_collection_factory;
		$this->source_factory = $source_factory;
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
		foreach ( $sources as &$source ) {
			$source = $this->remap_fields( $source );
		}
		$sources = $this->source_collection_factory->create( $sources );
		return $sources;
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
		$sources = $this->index( $params );
		if ( !is_object( $sources ) ) {
			return;
		}
		if ( $sources && is_object( $sources ) ) {
			return $sources[ $address ] ?? null;
		}
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
	}

	/**
	 * Updates the exisiting source by address
	 * @param SourceInterface $source Source to update
	 * @param array $params New source data
	 * @return SourceInterface
	 */
	public function update( SourceInterface $source, array $params ) {
		$params['address'] = $source->address_id;
		return $this->store( $params );
	}

	/**
	 * Destroys the existing source
	 * @param SourceInterface $source Source to destroy
	 * @return void
	 */
	public function destroy( SourceInterface $source ) {
		$this->client->deleteProvisionalSource( $source->address_id );
	}

	protected function remap_fields( array $source ) {
		$source['address_id'] = $source['address'];
		unset( $source['address'] );
		return $source; 
	}
}
