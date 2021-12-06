<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Services\Service;

/**
 * Provides the base functions for the other domain services
 */
class DomainService extends Service implements DomainServiceInterface {
	protected $memoized_instances = array();

	protected function index_after( $data, array $params = array() ) {
		$data = $this->handle_with( $data, $params );
		$this->memoize( $data, $params );
		return $data;
	}

	protected function show_before( array $params = array() ) {
		
	}

	protected function show_after( $data, array $params = array() ) {
		$data = $this->handle_with( $data, $params );
		$this->memoize( $data, $params );
		return $data;
	}

	protected function handle_with( $data, array $params = array() ) {
		if ( is_object( $data ) && isset( $params['with'] ) ) {
			$data->load( $params['with'] );
		}
		return $data;
	}

	protected function memoize( $data, array $params = array() ) {
		$hash = $this->make_memoize_hash( $params );
		$this->memoized_instances[ $hash ] = $data;
	}

	protected function get_memoized() {
		$hash = $this->make_memoize_hash( $params );
		if ( isset( $this->memoized_instances[ $hash ] ) ) {
			return $this->memoized_instances[ $hash ];
		} else {
			return false;
		}
	}

	protected function make_memoize_hash( array $params = array() ) {
		$hash = md5( serialize( $params ) );
		return $hash;
	}
}
