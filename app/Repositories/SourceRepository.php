<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository implements SourceRepositoryInterface {
	protected $client;
	protected $settings;
	protected $source_collection_factory;
	protected $current_user;
	
	public function __construct(
		TokenpassAPIInterface $client,
		SettingsInterface $settings,
		SourceCollectionFactoryInterface $source_collection_factory,
		CurrentUserInterface $current_user
	) {
		$this->client = $client;
		$this->settings = $settings;
		$this->source_collection_factory = $source_collection_factory;
		$this->current_user = $current_user;
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
		if ( isset( $params['with'] ) ) {
			$sources = $this->handle_with( $sources, $params['with'] );
		}
		$source = $sources[ $address ] ?? null;
		return $source;
	}

	/**
	 * Gets the list of registered source addresses
	 * @return array
	 */
	public function index( array $params = array() ) {
		$sources = $this->client->getProvisionalSourceList();
		$sources = $this->source_collection_factory->create( $sources );
		if ( isset( $params['with'] ) ) {
			$sources = $this->handle_with( $sources, $params['with'] );
		}
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

	/**
	 * Handles queries using parameter 'with'
	 * @param SourceCollectionInterface $sources Queried sources
	 * @return SourceCollectionInterface Modified sources
	 */
	protected function handle_with( SourceCollectionInterface $sources, array $with = array() ) {
		foreach ( $with as $with_rule ) {
			$with_rule = explode( '.', $with_rule );
			switch( $with_rule[0] ?? null ) {
				case 'address':
					if ( count( $with_rule ) > 1 ) {
						unset( $with_rule[0] );
						$with_rule = implode( '.', $with_rule );
					}
					$sources = $this->handle_with_address( $sources, array( $with_rule ) );
					break;
			}
		}
		return $sources;
	}

	/**
	 * Appends Address objects to the queried sources (part of 'with' handler)
	 * @param SourceCollectionInterface $sources Queried sources
	 * @return SourceCollectionInterface Modified sources
	 */
	protected function handle_with_address( SourceCollectionInterface $sources, $with_rule ) {
		if ( !isset( $this->current_user ) ) {
			return $sources;
		}
		$addresses = $this->current_user->get_addresses( array(
			'with' => $with_rule,
		) );
		$addresses->key_by_field( 'address' );
		$with_address = array_map( function( $source ) use ( $addresses ) {
			$address_data = $addresses[ $source->address ] ?? null;
			if ( $address_data ) {
				$source->address_data = $address_data;
			}
			return $source;
		}, ( array ) $sources );
		return $sources;
	}
}
