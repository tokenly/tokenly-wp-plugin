<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;

/**
 * Manages the posts
 */
class PostService extends DomainService implements PostServiceInterface {
	protected $meta_repository;
	protected $post_repository;
	protected $tca_rule_collection_factory;
	protected $tca_settings;
	protected $post_access_cache = array();

	public function __construct(
		MetaRepositoryInterface $meta_repository,
		PostRepositoryInterface $post_repository,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		TcaSettingsInterface $tca_settings,
		TcaServiceInterface $tca_service
	) {
		$this->meta_repository = $meta_repository;
		$this->post_repository = $post_repository;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
		$this->tca_settings = $tca_settings;
		$this->tca_service = $tca_service;
	}

	/**
	 * Searches for post using the specified parameters
	 * @param array $params Post search params 
	 * @return array
	 */
	public function show( array $params = array() ) {
		$post = $this->post_repository->show( $params );
		return $post;
	}

	/**
	 * Updates the data for the target post
	 * @param int $post_id Target post ID
	 * @param array $params New post data
	 * @return PostInterface 
	 */
	public function update( int $post_id, $params = array() ) {
		$update_params = array();
		if ( isset( $params['tca_rules'] ) ) {
			$update_params['tca_rules'] = $params['tca_rules'];
		}
		$post = $this->meta_repository->update( $post_id, $update_params );
		return $post;
	}

	/**
	 * Gets the TCA rules for the specified post
	 * @param int $post_id Target post ID
	 * @return TcaRuleCollectionInterface 
	 */
	public function get_tca_rules( int $post_id ) {
		$rules = $this->meta_repository->show( $post_id, 'tca_rules' ) ?? array();
		if ( empty( $rules ) ) {
			$rules = array();
		}
		$rules = $this->tca_rule_collection_factory->create( $rules );
		return $rules;
	}

	/**
	 * Sets the TCA rules for the specified post
	 * @param int $post_id Target post ID
	 * @param TcaRuleCollectionInterface $rules Rules to store
	 * @return void
	 */
	public function set_tca_rules( int $post_id, TcaRuleCollectionInterface $rules ) {
		$rules = $rules->to_array();
		$this->meta_repository->update( 'tca_rules', $rules );
	}

	/**
	 * Main pipeline for post access check
	 * @param int $post_id ID of the post to check
	 * @param UserInterface $user User to check
	 * @return bool
	 */
	public function can_access_post( int $post_id, UserInterface $user ) {
		$cached_access = $this->get_cached_access( $post_id, $user->ID );
		if ( $cached_access ) {
			return $cached_access;
		}
		$can_access = $this->test_access( $post_id, $user );
		$this->set_cached_access( $can_access, $post_id, $user->ID );
		return $can_access;
	}

	/**
	 * Check if the specified user is allowed to access
	 * the specified post
	 * @param int $post_id ID of the post to check
	 * @param int $user_id ID of the user to check
	 * @return bool
	 */
	protected function test_access( int $post_id, UserInterface $user ) {
		$can_access = false;
		$post_type = get_post_type( $post_id );
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $post_type );
		if ( $tca_enabled === false ) {
			return true;
		}
		$tca_rules = $this->get_tca_rules( $post_id );
		if ( count( $tca_rules ) === 0 ) {
			return true;
		}
		if ( $user instanceof GuestUserInterface === true ) {
			return false;
		}
		if ( user_can( $user, 'administrator' ) ) {
			return true;
		}
		$tca_allowed = $user->check_token_access( $tca_rules ) ?? false;
		return $tca_allowed;
	}

	/**
	 * Retrieves access decision for the post from cache
	 * @param int $post_id ID of the post to check
	 * @param int $user_id ID of the user to check
	 * @return bool
	 */
	protected function get_cached_access( int $post_id, int $user_id ) {
		if (
			isset( $this->post_access_cache[ $post_id ] ) &&
			isset( $this->post_access_cache[ $post_id ][ $user_id ] )
		) {
			return $this->post_access_cache[ $post_id ][ $user_id ] ?? false;
		}
	}

	/**
	 * Stores access decision for the post in cache
	 * @param bool $allowed Access decision
	 * @param int $post_id ID of the post to store
	 * @param int $user_id ID of the user to store
	 * @return void
	 */
	protected function set_cached_access( bool $allowed, int $post_id, int $user_id ) {
		if ( !isset( $this->post_access_cache[ $post_id ] ) ) {
			$this->post_access_cache[ $post_id ] = array();
		}
		$this->post_access_cache[ $post_id ][ $user_id ] = $allowed;
	}
}



