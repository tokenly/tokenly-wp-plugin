<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaAccessReportFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessReportInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;


class User extends Model implements UserInterface, CurrentUserInterface {
	public $user;
	public $oauth_user;
	public $oauth_token;
	public $uuid;
	public $can_connect;
	protected $oauth_user_service;
	protected $user_meta_repository;
	protected $tca_access_report_factory;
	protected $fillable = array(
		'user',
		'oauth_user',
		'oauth_token',
		'uuid',
		'can_connect',
	);

	public function __construct(
		OauthUserServiceInterface $oauth_user_service,
		UserMetaRepositoryInterface $user_meta_repository,
		UserRepositoryInterface $domain_repository,
		TcaAccessReportFactoryInterface $tca_access_report_factory,
		array $data = array()
	) {
		$this->oauth_user_service = $oauth_user_service;
		$this->user_meta_repository = $user_meta_repository;
		$this->domain_repository = $domain_repository;
		$this->tca_access_report_factory = $tca_access_report_factory;
		parent::__construct( $data );
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
	
	public function is_guest() {
		return false;
	}
	
	public function to_array() {
		$array = parent::to_array();
		$array = array_merge( $array, array(
			'id'   => $this->ID,
			'name' => $this->user_nicename,
		) );
		return $array;
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @return bool
	 */
	public function can_connect() {
		return $this->can_connect;
	}

	/**
	 * Connects the user to Tokenpass
	 * @param OauthUserInterface $oauth_user OAuth user to associate the current user with
	 * @param string $oauth_token OAuth token of the OAuth user
	 * @return self
	 */
	public function connect( OauthUserInterface $oauth_user, string $oauth_token ) {
		$this->update( array(
			'uuid'        => $oauth_user->id,
			'oauth_token' => $oauth_token,
			'can_connect' => true,
		) );
		$this->add_cap( 'use_tokenpass' );
		return $this;
	}

	/**
	 * Disconnects the user from Tokenpass
	 * @return void
	 */
	public function disconnect() {
		$this->user_meta_repository->destroy( $this->ID, ...array( 'uuid', 'oauth_token', 'can_connect' ) );
		$this->remove_cap( 'use_tokenpass');
		return $this;
	}

	/**
	 * Checks if the user can pass the specified TCA rules
	 * @param TcaRuleCollectionInteface $rules Rules to test
	 * @return TcaAccessReportInterface
	 */
	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		if ( $need_test === true ) {
			$access_report = $this->oauth_user->check_token_access( $rules );
		} else {
			$access_report = $this->tca_access_report_factory->create( array(
				'hash'   => $hash,
				'status' => $user_status,
			) );
		}
		return $access_report;
	}

	/**
	 * Retrieves oauth user from the API
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_oauth_user( array $relations = array() ) {
		if ( isset( $this->oauth_user ) ) {
			return $this;
		}
		$oauth_user = $this->oauth_user_service->show(
			array(
				'id'   => $this->ID,
				'with' => $relations,
			)
		);
		$this->oauth_user = $oauth_user;
		return $this;
	}
}
