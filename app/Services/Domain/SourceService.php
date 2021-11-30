<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;

/**
 * Manages the sources
 */
class SourceService extends DomainService implements SourceServiceInterface {
	protected $source_cache;
	protected $source_repository;
	protected $current_user;

	public function __construct(
		SourceRepositoryInterface $source_repository,
		CurrentUserInterface $current_user
	) {
		$this->source_repository = $source_repository;
		$this->current_user = $current_user;
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
			if ( $sources == false ) {
				return false;
			}
			$this->source_cache = $sources;
		}
		if ( isset( $params['with'] ) ) {
			$sources = $this->load( $sources, $params['with'] );
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
			$source = $this->load( $source, $params['with'] );
		}
		return $source;
	}
	
	/**
	 * Registers the source address for the current integration
	 * @param array $source New source address data
	 * @return boolean
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
		$this->source_repository->store( $address, $type, $proof, $assets );
	}

	/**
	 * Updates the exisiting source by address
	 * @param array $params New source data
	 * @return boolean
	 */
	public function update( array $params ) {
		return $this->store( $params );
	}

	/**
	 * Destroys the existing source by address
	 * @param string $address
	 * @return void
	 */
	public function destroy( string $address ) {
		$this->source_repository->destroy( $address );
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

	/**
	 * Appends Address object to the queried source
	 * @param SourceInterface $sources Queried source
	 * @return SourceInterface Modified source
	 */
	protected function load_address( SourceInterface $source, array $relation ) {
		if ( $this->current_user->is_guest() === true ) {
			return $source;
		}
		$addresses = $this->current_user->get_addresses( array(
			'with' => $relation,
		) );
		$addresses->key_by_field( 'address' );
		$address_data = $addresses[ $source->address ] ?? null;
		if ( $address_data ) {
			$source->address_data = $address_data;
		}
		return $source;
	}

	/**
	 * Appends Address objects to the queried sources
	 * @param SourceCollectionInterface $sources Queried sources
	 * @return SourceCollectionInterface Modified sources
	 */
	protected function load_address_collection( SourceCollectionInterface $sources, array $relation ) {
		if ( $this->current_user->is_guest() === true ) {
			return $sources;
		}
		$addresses = $this->current_user->get_addresses( array(
			'with' => $relation,
		) );
		$addresses->key_by_field( 'address' );
		foreach ( $sources as &$source ) {
			$address_data = $addresses[ $source->address ] ?? null;
			if ( $address_data ) {
				$source->address_data = $address_data;
			}
		}
		return $sources;
	}
}
