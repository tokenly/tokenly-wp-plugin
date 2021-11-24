<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;

class SourceService implements SourceServiceInterface {
	protected $source_cache = array();
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
	public function index( array $params = array() ) {
		$sources;
		if ( isset( $this->source_cache ) ) {
			$sources = $this->source_cache;
		} else {
			$sources = $this->source_repository->index();
			$this->source_cache = $sources;
		}
		if ( isset( $params['with'] ) ) {
			$sources = $this->handle_with( $sources, $params['with'] );
		}
		return $sources;
	}

	/**
	 * Gets the source data by address
	 * @param string $address Source address
	 * @return array
	 */
	public function show( array $params = array() ) {
		$source = $this->source_repository->show( $params );
		if ( !$source ) {
			return;
		}
		if ( isset( $params['with'] ) ) {
			$source = $this->handle_with( $source, $params['with'] );
		}
		return $source;
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
		$this->source_repository->store( $address, $type, $proof, $assets );
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
		$this->source_repository->destroy( $address );
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
		if ( $this->current_user->is_guest() === true ) {
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
