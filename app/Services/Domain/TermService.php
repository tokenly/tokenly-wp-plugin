<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
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
	 * Gets a collection of terms
	 * @param array $params Search parameters 
	 * @return TermCollectionInterface
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single term
	 * @param array $params Search parameters
	 * @return TermInterface
	 */
	public function show( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters 
	 * @return TermCollectionInterface
	 */
	protected function index_cacheable( array $params = array() ) {
		$term = $this->term_repository->index( $params );
		return $term;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return TermInterface
	 */
	protected function show_cacheable( array $params = array() ) {
		$term = $this->term_repository->show( $params );
		return $term;
	}
}



