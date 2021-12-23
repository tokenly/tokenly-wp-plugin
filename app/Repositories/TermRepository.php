<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TermFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TermCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;

/**
 * Manages terms
 */
class TermRepository implements TermRepositoryInterface {
	protected $term_factory;
	protected $term_collection_factory;
	protected $term_meta_repository;
	protected $tca_rule_collection_factory;
	protected $meta = array(
		'tca_rules',
	);
	
	public function __construct(
		TermFactoryInterface $term_factory,
		TermCollectionFactoryInterface $term_collection_factory,
		TermMetaRepositoryInterface $term_meta_repository,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory
	) {
		$this->term_factory = $term_factory;
		$this->term_collection_factory = $term_collection_factory;
		$this->term_meta_repository = $term_meta_repository;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
	}

	/**
	 * Retrieves a collection of terms
	 * @param array $params Search paramters
	 * @return TermCollectionInterface
	 */
	public function index( array $params = array() ) {
		$args = $this->get_query_args( $params );
		$terms = $this->query( $args );
		if ( !$terms ) {
			$terms = array();
		}
		$terms = $this->append_meta_collection( $terms );
		$terms = $this->term_collection_factory->create( $terms );
		return $terms;
	}

	/**
	 * Queries the term matching the params
	 * @param array $params Search params
	 * @return TermInterface
	 */
	public function show( array $params = array() ) {
		$params['number'] = 1;
		$args = $this->get_query_args( $params );
		$terms = $this->query( $args );
		error_log( d($params) );
		if ( !isset( $terms[0] ) ) {
			return;
		}
		$term = $terms[0];
		$term = $this->append_meta( $term );
		$term = $this->term_factory->create( $term );
		return $term;
	}

	/**
	 * Gets the query arguments for the Show and Index methods
	 * @param array $params Search parameters
	 * @return array
	 */
	protected function get_query_args( array $params = array() ) {
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
	protected function filter_meta_params( array $params = array() ) {
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
	protected function query( array $args = array() ) {
		$query = new \WP_Term_Query( $args );
		$terms = $query->terms;
		return $terms;
	}

	/**
	 * Updates the specific term
	 * @param TermInterface $term Target term
	 * @param array $params New data
	 * @return void
	 */
	public function update( TermInterface $term, array $params = array() ) {
		$params = $this->filter_meta_params( $params );
		$this->term_meta_repository->update( $term->term_id, $params );
		return $term;
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields() {
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
	protected function load_meta( \WP_Term $term ) {
		$meta = $this->term_meta_repository->index( $term->term_id, ...$this->meta );
		if ( isset( $meta['tca_rules'] ) && is_array( $meta['tca_rules'] ) ) {
			$meta['tca_rules'] = $this->tca_rule_collection_factory->create( $meta['tca_rules'] );
		}
		return $meta;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_Term $term Term to target
	 * @return array
	 */
	protected function append_meta( \WP_Term $term ) {
		$meta = $this->load_meta( $term );
		$term = array_merge( array(
			'term' => $term,
		), $meta );
		return $term;
	}

	/**
	 * Loads the meta for a collection of terms
	 * @param array $terms Terms to target
	 * @return array
	 */
	protected function append_meta_collection( array $terms ) {
		foreach ( $terms as &$term ) {
			$term = $this->append_meta( $term );
		}
		return $terms;
	}
}
