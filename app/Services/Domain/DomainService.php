<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Services\Service;

/**
 * Provides the base functions for the other domain services
 */
class DomainService extends Service implements DomainServiceInterface {
	protected function index_after( $data, array $params = array() ) {
		return $this->handle_with( $data, $params );
	}

	protected function show_after( $data, array $params = array() ) {
		return $this->handle_with( $data, $params );
	}

	protected function handle_with( $data, array $params = array() ) {
		if ( is_object( $data ) && isset( $params['with'] ) ) {
			$data->load( $params['with'] );
		}
		return $data;
	}
}
