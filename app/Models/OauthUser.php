<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

class OauthUser extends Model implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;
	public $oauth_token;
	protected $tca_service;
	protected $oauth_user_service;

	public function __construct(
		array $data = array(),
		TcaServiceInterface $tca_service,
		OauthUserServiceInterface $oauth_user_service
	) {
		$this->tca_service = $tca_service;
		$this->oauth_user_service = $oauth_user_service;
		$this->fill( $data );
	}

	public function fill( array $data ) {
		if ( isset( $oauth_user_data['id'] ) ) {
			$this->id = $oauth_user_data['id'];
		}
		if ( isset( $oauth_user_data['username'] ) ) {
			$this->username = $oauth_user_data['username'];
		}
		if ( isset( $oauth_user_data['email'] ) ) {
			$this->email = $oauth_user_data['email'];
		}
		if ( isset( $oauth_user_data['name'] ) ) {
			$this->name = $oauth_user_data['name'];
		}
		if ( isset( $oauth_user_data['email_is_confirmed'] ) ) {
			$this->email_is_confirmed = $oauth_user_data['email_is_confirmed'];
		}
		if ( isset( $oauth_user_data['oauth_token'] ) ) {
			$this->oauth_token = $oauth_user_data['oauth_token'];
		}
		return $this;
	}

	public function to_array() {
		$array = array();
		if ( isset( $this->id ) ) {
			$array['id'] = $this->id;
		}
		if ( isset( $this->client_secret ) ) {
			$array['client_secret'] = $this->client_secret;
		}
		if ( isset( $this->settings_updated ) ) {
			$array['settings_updated'] = $this->settings_updated;
		}
		return $array;
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @param array $tokenpass_user
	 * @return bool
	 */
	public function can_social_login() {
		$email = $this->email ?? null;
		$email_is_confirmed = $this->email_is_confirmed ?? null;
		if ( !$email || $email_is_confirmed == false ) {
			return false;	
		}
		return true;
	}

	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$can_access = $this->tca_service->check_token_access_user( $this, $rules );
		return $can_access;
	}
}
