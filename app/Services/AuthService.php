<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Components\ButtonLoginComponent;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Handles the Tokenpass authentication flow (OAuth)
 */
class AuthService implements AuthServiceInterface {
	public $client;
	public $user_service;
	public $button_login_component;
	public $settings_repository;

	public function __construct(
		TokenpassAPIInterface $client,
		UserServiceInterface $user_service,
		SettingsRepositoryInterface $settings_repository,
		UserMetaRepositoryInterface $user_meta_repository,
		ButtonLoginComponent $button_login_component
	) {
		$this->client = $client;
		$this->user_service = $user_service;
		$this->button_login_component = $button_login_component;
		$this->settings_repository = $settings_repository;
		$this->user_meta_repository = $user_meta_repository;
	}

	/**
	 * Updates the session identifier cookie.
	 * @param string $state New session identifier
	 * @return void
	 */
	public function set_state( $state ) {
		setcookie( 'tokenpass-state', $state, time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Removes the session identifier cookie
	 * @return void
	 */
	public function delete_state() {
		setcookie( 'tokenpass-state', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Checks if the input session identifier matches the one currently stored.
	 * @param string $state Session identifier
	 * @return boolean
	 */
	public function validate_state( $state ) {
		$cookie = $_COOKIE['tokenpass-state'];
		$valid = false;
		if ( $cookie ) {
			$valid = $cookie === $state;
		}
		return $valid;
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @param array $tokenpass_user
	 * @return boolean
	 */
	public function can_social_login( $tokenpass_user ) {
		$email = $tokenpass_user['email'] ?? null;
		$email_is_confirmed = $tokenpass_user['email_is_confirmed'] ?? null;
		if ( !$email || $email_is_confirmed === false ) {
			return false;	
		}
		return true;
	}

	/**
	 * Searches for WordPress user using Tokenpass user data
	 * @param array $tokenpass_user
	 * @return WP_User
	 */
	public function find_existing_user( $tokenpass_user ) {
		$uuid = $tokenpass_user['id'] ?? null;
		$email = $tokenpass_user['email'] ?? null;
		$user;
		if ( $uuid ) {
			$user = $this->user_service->get_by_uuid( $uuid );
			if ( $user ) {
				return $user;
			}
			
		}
		if ( $email ) {
			$user = get_user_by( 'email', $email );
			if ( $user ) {
				return $user;
			}
		}
	}

	/**
	 * Generates a new WordPress user using Tokenpass data
	 * @param array $tokenpass_user
	 * @return WP_User 
	 */

	public function create_user_from_tokenpass_user( $tokenpass_user ) {
		$username = $tokenpass_user['username'] ?? null;
		$password = wp_generate_password( 12, false );
		$email = $tokenpass_user['email'] ?? null;
		$user_id = wp_create_user( $username, $password, $email );
		if ( is_numeric( $user_id ) === false ) {
			return false;
		}
		$user = get_user_by( 'id', $user_id );
		return $user;
	}

	/**
	 * Handles response from the Tokenpass OAuth service
	 * @param string $state Unique identifier
	 * @param string $code Unique identifier
	 * @return void
	 */
	public function authorize_callback( $state, $code ) {
		$is_valid = $this->validate_state( $state );
		if ( $is_valid === false ) {
			return;
		}
		$access_token = $this->client->getOAuthAccessToken( $code );
		if ( !$access_token ) {
			return;
		}
		$tokenpass_user = $this->client->getUserByToken( $access_token );
		if ( $tokenpass_user ) {
			$user = wp_get_current_user();
			if ( is_user_logged_in() === false ) {
				$can_login = $this->can_social_login( $tokenpass_user );
				if ( $can_login === false ) {
					return;
				}
				$user = $this->find_existing_user( $tokenpass_user );
				if ( !$user ) {
					$user = $this->create_user_from_tokenpass_user( $tokenpass_user );
				}
			}
			if ( !$user ) {
				return;
			}
			$uuid = $tokenpass_user['id'] ?? null;
			$this->user_meta_repository->update( $user->ID, array(
				'uuid'        => $uuid,
				'oauth_token' => $access_token,
			) );
			$user->add_cap( 'use_tokenpass' );
			wp_set_auth_cookie( $user->ID );
		}
	}

	/**
	 * Embeds Tokenpass login button on the WordPress login page
	 * @return void
	 */
	public function embed_tokenpass_login() {
		echo $this->button_login_component->render();
	}

	/**
	 * Validates the Tokenpass login link and returns it to the user
	 * @return array
	 */
	public function authorize_begin() {
		$this->delete_state();
		$result = $this->get_tokenpass_login_url();
		if ( $result ) {
			$args = $result['args'] ?? null;
			if ( !$args ) {
				return;
			}
			$state;
			$state = $args['state'] ?? null;
			if ( !$state ) {
				return;
			}
			$url = $result['url'] ?? null;
			if ( !$url ) {
				return;
			}
			$this->set_state( $state );
			return array(
				'url' => $url,
			);
		}
	}

	/**
	 * Checks if the user is currently connected to Tokenpass
	 * @param $id WordPress user id
	 * @return boolean
	 */
	public function is_connected( $id ) {
		$uuid = get_user_meta( $id, 'tokenly_uuid' );
		if ( $uuid && $uuid[0] ?? null && !empty( $uuid[0] ) ) {
			return true;
		} else {
			return false;
		};
	}
	
	/**
	 * Disconnects the current user from Tokenpass
	 * @return void
	 */
	public function disconnect() {
		$user = wp_get_current_user();
		if ( $user ) {
			delete_user_meta( $user->ID, 'tokenly_uuid' );
			delete_user_meta( $user->ID, 'tokenly_oauth_token' );
			$user->remove_cap( 'use_tokenpass');
		}
	}

	/**
	 * Constructs Tokenpass OAuth login link
	 * @return array
	 */
	public function get_tokenpass_login_url() {
		$settings = $this->settings_repository->show();
		$client_id;
		if ( $settings ) {
			$client_id = $settings['client_id'] ?? null;
		}

		$state = wp_generate_password( 12, false );
		$args = array(
			'client_id'     => $client_id,
			'redirect_uri'  => TOKENLY_PLUGIN_AUTH_REDIRECT_URI,
			'scope'         => 'user,tca',
			'response_type' => 'code',
			'state'         => $state,
		);
		$url = add_query_arg( $args, 'https://tokenpass.tokenly.com/oauth/authorize' );
		return array(
			'args' => $args,
			'url'  => $url,
		);
	}
}
