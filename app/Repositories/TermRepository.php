<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;

use Tokenly\Wp\Collections\TermCollection;
use Tokenly\Wp\Models\Term;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;

/**
 * Manages terms
 */
class TermRepository extends Repository implements TermRepositoryInterface {
	protected string $class = Term::class;
	protected string $class_collection = TermCollection::class;
	protected TermMetaRepositoryInterface $term_meta_repository;
	protected array $meta;
	
	public function __construct(
		TermMetaRepositoryInterface $term_meta_repository
	) {
		$this->term_meta_repository = $term_meta_repository;
		$this->meta = $this->get_meta_fields();
	}

	/**
	 * Gets a collection of terms
	 * @param array $params Search parameters 
	 * @return TermCollectionInterface
	 */
	public function index( array $params = array() ): TermCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single term
	 * @param array $params Search parameters
	 * @return TermInterface|null
	 */
	public function show( array $params = array() ): ?TermInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Decorates and updates the term
	 * @return void
	 */
	public function update( TermInterface $term, array $params = array() ): void {
		$params = $this->filter_meta_params( $params );
		$this->term_meta_repository->update( $term->term_id, $params );
	}

	public function destroy( TermInterface $term ): void {
		$this->term_repository->destroy( $term );
	}

	/**
	 * Decorates a single term
	 * @param \WP_Term $term Term to decorate
	 * @return TermInterface|null
	 */
	public function complete( \WP_Term $term ): ?TermInterface {
		$term = $this->append_meta( $term );
		$term = ( new $this->class() )->from_array( $term );
		return $term;
	}

	/**
	 * Decorates a collection of terms
	 * @param \WP_Term[] $terms Terms to decorate
	 * @return TermCollectionInterface
	 */
	public function complete_collection( array $terms = array() ): TermCollectionInterface {
		$terms = $this->append_meta_collection( $terms );
		$terms = ( new $this->class_collection() )->from_array( $terms );
		return $terms;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters 
	 * @return TermCollectionInterface
	 */
	protected function index_cacheable( array $params = array() ): TermCollectionInterface {
		$args = $this->get_query_args( $params );
		$terms = $this->query( $args );
		if ( !$terms ) {
			$terms = array();
		}
		$terms = $this->complete_collection( $terms );
		return $terms;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return TermInterface|null
	 */
	protected function show_cacheable( array $params = array() ): ?TermInterface {
		$params['number'] = 1;
		$args = $this->get_query_args( $params );
		$terms = $this->query( $args );
		if ( !isset( $terms[0] ) ) {
			return null;
		}
		$term = $terms[0];
		$term = $this->complete( $term );
		return $term;
	}

	/**
	 * Gets the query arguments for the Show and Index methods
	 * @param array $params Search parameters
	 * @return array
	 */
	protected function get_query_args( array $params = array() ): array {
		$args = array(
			'meta_query' => array(),
			'hide_empty' => false,
		);
		if ( isset( $params['taxonomy'] ) ) {
			$args['taxonomy'] = $params['taxonomy'];
		}
		if ( isset( $params['include'] ) ) {
			$args['include'] = $params['include'];
		}
		if ( isset( $params['id'] ) ) {
			$args['object_ids'] = $params['id'];
		}
		if ( isset( $params['number'] ) ) {
			$args['number'] = $params['number'];
		}
		return $args;
	}

	/**
	 * Filters the specified array accoring to the meta property
	 * @param array $params Array to filter
	 * @return array
	 */
	protected function filter_meta_params( array $params = array() ): array {
		foreach ( $params as $key => $param ) {
			if ( !in_array( $key, $this->meta ) ) {
				unset( $params[ $key ] );
			}
		}
		return $params;
	}

	/**
	 * Searches for terms using the specified arguments
	 * @param array $args Search arguments
	 * @return array
	 */
	protected function query( array $args = array() ): array {
		$query = new \WP_Term_Query( $args );
		$terms = $query->terms;
		if ( !$terms ) {
			$terms = array();
		}
		return $terms;
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields(): array {
		return array(
			'tca_rules',
		);
	}

	/**
	 * Gets the meta fields associated with the term
	 * after retrieving the term
	 * @param \WP_Term $term Term to target
	 * @return array
	 */
	protected function load_meta( \WP_Term $term ): array {
		$meta = $this->term_meta_repository->index( $term->term_id, ...$this->meta );
		return $meta;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_Term $term Term to target
	 * @return array
	 */
	protected function append_meta( \WP_Term $term ): array {
		$meta = $this->load_meta( $term );
		$term = array_merge( array(
			'term' => $term,
		), $meta );
		$term = $this->format_item( $term );
		return $term;
	}

	/**
	 * Loads the meta for a collection of terms
	 * @param array $terms Terms to target
	 * @return array
	 */
	protected function append_meta_collection( array $terms ): array {
		foreach ( $terms as &$term ) {
			$term = $this->append_meta( $term );
		}
		return $terms;
	}
}
