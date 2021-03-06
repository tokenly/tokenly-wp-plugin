<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Models\ProtectableInterface;
use Tokenly\Wp\Traits\ProtectableTrait;

use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Tca\AccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

/**
 * WP_Post decorator
 */
class Post extends Model implements PostInterface, ProtectableInterface {
	use ProtectableTrait;

	public $term;
	protected $post = null;
	protected $tca_settings;
	protected $term_service;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostRepositoryInterface $domain_repository,
		TcaSettingsInterface $tca_settings,
		TermServiceInterface $term_service,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->tca_settings = $tca_settings;
		$this->term_service = $term_service;
		parent::__construct( $data );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->post, $method ), $args );
	}

	public function __get( $key ) {
		return $this->post->$key;
	}

	public function __set( $key, $val ) {
		return $this->post->$key = $val;
	}

	/* Protectable trait */

	/**
	 * Gets the TCA rules associated with the relations
	 * @return array
	 */
	protected function get_tca_rules_relation() {
		$rules = array();
		$this->load( array( 'term' ) );
		if ( isset( $this->term ) && $this->term instanceof TermCollectionInterface ) {
			$term_rules = $this->term->get_tca_rules();
			if (
				$term_rules &&
				is_array( $term_rules ) &&
				count( $term_rules ) > 0
			) {
				$rules = array_merge( $rules, $term_rules );
			}
		}
		return $rules;
	}

	/**
	 * Checks if TCA is enabled for the post type
	 * @return bool
	 */
	protected function check_tca_enabled() {
		return $this->tca_settings->is_enabled_for_post_type( $this->post_type ) ?? false;
	}

	/**
	 * Checks if any relations are protected
	 * @return bool
	 */
	protected function check_relations_protected() {
		$terms_protected = false;
		$this->load( array( 'term' ) );
		if ( isset( $this->term ) && $this->term instanceof TermCollectionInterface ) {
			$terms_protected = $this->term->is_protected();
		}
		if ( $terms_protected === true ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Test if the specified user is allowed to access the relations
	 * @param UserInterface $user User to test
	 * @return AccessVerdictInterface
	 */
	protected function test_access_relations( UserInterface $user ) {
		$this->load( array( 'term' ) );
		$verdict = null;
		if ( $this->term && $this->term instanceof TermCollectionInterface ) {
			$verdict = $this->term->can_access( $user );
		}
		return $verdict;
	}

	/* Relations */

	/**
	 * Loads the term relation
	 * @param string[] $relations Further relations
	 * @return TermCollectionInterface
	 */
	protected function load_term( array $relations = array() ) {
		$term = $this->term_service->index( array(
			'id' => $this->ID,
		) );
		return $term;
	}
}
