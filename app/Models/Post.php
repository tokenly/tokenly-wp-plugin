<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class Post extends Model implements PostInterface {
	public $tca_rules;
	public $term;
	protected $post = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $tca_rule_collection_factory;
	protected $term_service;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostRepositoryInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaSettingsInterface $tca_settings,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		TermServiceInterface $term_service,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
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

	/**
	 * Main pipeline for post access check
	 * @param int $post_id ID of the post to check
	 * @param UserInterface $user User to check
	 * @return bool
	 */
	public function can_access_post( UserInterface $user ) {
		$can_access = $this->test_access( $user );
		return $can_access;
	}

	/**
	 * Checks if the specified user can access the terms of the post
	 * and the post itself
	 * @param UserInterface $user User to check
	 * @return bool
	 */
	protected function test_access( UserInterface $user ) {
		if ( user_can( $user, 'administrator' ) ) {
			return true;
		}
		$can_access_terms = $this->test_access_terms( $user );
		if ( $can_access_terms === false ) {
			return false;
		}
		$post_tca_enabled = $this->tca_settings->is_enabled_for_post_type( $this->post_type );
		if ( $post_tca_enabled === false ) {
			return true;
		}
		if ( count( (array) $this->tca_rules ) == 0 ) {
			return true;
		}
		$can_access_post = $user->check_token_access( $this->tca_rules ) ?? false;
		return $can_access_post;
	}

	protected function test_access_terms( UserInterface $user ) {
		$this->load( array( 'term' ) );
		if ( count( (array) $this->term ) === 0 ) {
			return true;
		}
		foreach ( ( array ) $this->term as $term ) {
			$can_access = $term->can_access_term( $user );
			if ( $can_access == false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Loads the term relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_term( array $relations = array() ) {
		$terms = $this->term_service->index( array(
			'id' => $this->ID,
		) );
		if ( !$terms ) {
			return;
		}
		$this->term = $terms;
		return $this;
	}
}
