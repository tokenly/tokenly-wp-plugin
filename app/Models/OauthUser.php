<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class OauthUser implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;

	public function __construct(
		$oauth_user_data = array()
	) {
		$this->from_array( $oauth_user_data );
	}

	public function from_array( $oauth_user_data ) {
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
}
