<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;

class User extends Model implements UserInterface, CurrentUserInterface {
	protected $user;
	public $oauth_user;
	protected $oauth_user_service;
	protected $user_meta_repository;
	protected $fillable = array(
		'user',
		'oauth_user',
	);

	public function __construct(
		OauthUserServiceInterface $oauth_user_service,
		UserMetaRepositoryInterface $user_meta_repository,
		array $data = array()
	) {
		$this->user = $user;
		$this->oauth_user_service = $oauth_user_service;
		$this->user_meta_repository = $user_meta_repository;
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->user, $method ), $args );
	}

	public function __get( $key ) {
		return $this->user->$key;
	}

	public function __set( $key, $val ) {
		return $this->user->$key = $val;
	}

	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$this->load( 'oauth_user' );
		if ( !isset( $this->oauth_user ) ) {
			return false;
		}
		$can_access = $this->oauth_user->check_token_access( $rules );
		return $can_access;
	}
	
	public function is_guest() {
		return false;
	}
	
	public function to_array() {
		return array(
			'id'   => $this->ID,
			'name' => $this->user_nicename,
		);
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @return bool
	 */
	public function can_connect() {
		$can_connect =  $this->user_meta_repository->show( $this->ID, 'can_connect' ) ?? false;
		return $can_connect;
	}

	public function connect( OauthUserInterface $oauth_user, string $oauth_token ) {
		$this->update( array(
			'uuid'        => $oauth_user->id,
			'oauth_token' => $oauth_token,
			'can_connect' => true,
		) );
		$this->add_cap( 'use_tokenpass' );
	}

	/**
	 * Disconnects the user from Tokenpass
	 * @return void
	 */
	public function disconnect() {
		$this->user_meta_repository->destroy( $this->ID, ...array( 'uuid', 'oauth_token', 'can_connect' ) );
		$this->remove_cap( 'use_tokenpass');
	}

	/**
	 * Retrieves oauth user from the API
	 * @return self
	 */
	protected function load_oauth_user() {
		if ( isset( $this->oauth_user ) ) {
			return $this;
		}
		$oauth_user = $this->oauth_user_service->show( array( 'id' => $this->ID ) );
		$this->oauth_user = $oauth_user;
		return $this;
	}

	/**
	 * Retrieves oauth token from the options
	 * @return string
	 */
	public function get_oauth_token() {
		$oauth_token = $this->user_meta_repository->show( $this->ID, 'oauth_token' );
		return $oauth_token;
	}
}
