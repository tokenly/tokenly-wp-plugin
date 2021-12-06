<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

class Post extends Model implements PostInterface {
	public $tca_rules;
	protected $post = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostServiceInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaSettingsInterface $tca_settings,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
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
	 * Check if the specified user is allowed to access
	 * the specified post
	 * @param int $post_id ID of the post to check
	 * @param int $user_id ID of the user to check
	 * @return bool
	 */
	protected function test_access( UserInterface $user ) {
		$post_id = $this->ID;
		$can_access = false;
		$post_type = $this->post_type;
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $post_type );
		if ( $tca_enabled === false ) {
			return true;
		}
		if ( count( (array) $this->tca_rules ) === 0 ) {
			return true;
		}
		if ( $user instanceof GuestUserInterface === true ) {
			return false;
		}
		if ( user_can( $user, 'administrator' ) ) {
			return true;
		}
		$tca_allowed = $user->check_token_access( $this->tca_rules ) ?? false;
		return $tca_allowed;
	}
}
