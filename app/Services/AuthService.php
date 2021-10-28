<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Components\ButtonLoginComponent;
use Tokenly\TokenpassClient\TokenpassAPI;

class AuthService {
	public $client;
	public $user_service;
	public $button_login_component;

	public function __construct(
		TokenpassAPI $client,
		UserService $user_service,
		ButtonLoginComponent $button_login_component
	) {
		$this->client = $client;
		$this->user_service = $user_service;
		$this->button_login_component = $button_login_component;
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

	public function can_social_login( $tokenpass_user ) {
		$email = $tokenpass_user['email'] ?? null;
		$email_is_confirmed = $tokenpass_user['email_is_confirmed'] ?? null;
		if ( !$email || $email_is_confirmed === false ) {
			return false;	
		}
		return true;
	}

	public function find_existing_user( $tokenpass_user ) {
		$uuid = $tokenpass_user['id'] ?? null;
		$email = $tokenpass_user['email'] ?? null;
		$user;
		if ( $uuid ) {
			$user = $this->user_service->get_by_uuid( $uuid );
			
		} else if ( $email ) {
			$user = get_user_by( 'email', $email );
		}
		return $user;
	}

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
			update_user_meta( $user->ID, 'tokenly_uuid', $tokenpass_user['id'] ?? null );
			update_user_meta( $user->ID, 'tokenly_oauth_token', $access_token );
			$user->add_cap( 'use_tokenpass');
			wp_set_auth_cookie( $user->ID );
		}
	}

	public function embed_tokenpass_login() {
		echo $this->button_login_component->render();
	}

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
			error_log($url);
			return array(
				'url' => $url,
			);
		}
	}

	public function is_connected( $id ) {
		$uuid = get_user_meta( $id, 'tokenly_uuid' );
		if ( $uuid && $uuid[0] ?? null && !empty( $uuid[0] ) ) {
			return true;
		} else {
			return false;
		};
	}
	
	public function disconnect() {
		$user = wp_get_current_user();
		if ( $user ) {
			delete_user_meta( $user->ID, 'tokenly_uuid' );
			delete_user_meta( $user->ID, 'tokenly_oauth_token' );
			$user->remove_cap( 'use_tokenpass');
		}
	}

	public function get_tokenpass_login_url() {
		$settings = get_option( 'tokenpass_settings' );
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
