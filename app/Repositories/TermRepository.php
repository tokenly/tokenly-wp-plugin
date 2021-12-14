<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TermFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;

/**
 * Manages post data
 */
class TermRepository implements TermRepositoryInterface {
	protected $term_factory;
	
	public function __construct(
		TermFactoryInterface $term_factory
	) {
		$this->term_factory = $term_factory;
	}

	/**
	 * Queries the term matching the params
	 * @param array $params Search params
	 * @return TermInterface
	 */
	public function show( array $params = array() ) {
		if (
			!isset( $params['id'] ) ||
			!isset( $params['taxonomy'] )
		) {
			return;
		}
		$id = $params['id'];
		$taxonomy = $params['taxonomy'];
		$term = get_term( $id, $taxonomy );
		if ( !$term ) {
			return;
		}
		$term = $this->term_factory->create( array(
			'term' => $term,
		) );
	}

	/**
	 * Updates the specific term
	 * @param TermInterface $term Target term
	 * @param array $params New data
	 * @return void
	 */
	public function update( TermInterface $term, array $params = array() ) {
		$update_params = array();
		if ( isset( $params['tca_rules'] ) ) {
			$update_params['tca_rules'] = $params['tca_rules'];
		}
		wp_update_term( $term->term_id, $term->taxonomy, $update_params );
	}
}
