<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;

/**
 * Manages the terms
 */
class TermService extends DomainService implements TermServiceInterface {
	protected $term_repository;

	public function __construct(
		TermRepositoryInterface $term_repository
	) {
		$this->term_repository = $term_repository;
	}

	/**
	 * Searches for terms using the specified parameters
	 * @param array $params Term search params 
	 * @return array
	 */
	protected function _index( array $params = array() ) {
		$term = $this->term_repository->index( $params );
		return $term;
	}

	/**
	 * Searches for term using the specified parameters
	 * @param array $params Term search params 
	 * @return array
	 */
	protected function _show( array $params = array() ) {
		$term = $this->term_repository->show( $params );
		return $term;
	}
}



