<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\TokenpassClient\TokenpassAPI;

class TokenpassService {
	public $api_router;
	
	public function __construct() {
		$this->api_router = new ApiRouter();
	}

	public function get_tokenpass_login_url() {
		$settings = get_option( 'tokenpass_settings' );
		error_log(print_r($settings, true));
		$client_id;
		if ( $settings ) {
			$client_id = $settings['client_id'] ?? null;
		}
		$redirect_uri = $this->api_router->get_route_url( 'authorize-callback' );
		$state = wp_generate_password( 12, false );
		$args = array(
			'client_id'     => $client_id,
			'redirect_uri'  => $redirect_uri,
			'scope'         => 'user',
			'response_type' => 'code',
			'state'         => $state,
		);
		$url = add_query_arg( $args, 'https://tokenpass.tokenly.com/oauth/authorize' );
		return array(
			'args' => $args,
			'url'  => $url,
		);
	}

	public function make_client() {
		$client_id = null;
		$client_secret = null;
		$privileged_client_id = null;
		$privileged_client_secret = null;
		$oauth_client_id = null;
		$oauth_client_secret = null;
		$settings = get_option( 'tokenpass_settings' );
		if ( $settings ) {
			$client_id = $settings['client_id'] ?? null;
			$client_secret = $settings['client_secret'] ?? null;
		}
		$tokenpass_url = 'https://tokenpass.tokenly.com';
		$redirect_uri = $this->api_router->get_route_url( 'authorize-callback' ) ?? null;
		return new TokenpassAPI( 
			$client_id,
			$client_secret,
			$privileged_client_id,
			$privileged_client_secret,
			$tokenpass_url,
			$redirect_uri,
			$oauth_client_id,
			$oauth_client_secret
		);
	}
}
