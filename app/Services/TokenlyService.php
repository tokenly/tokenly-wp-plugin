<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Router;

class TokenlyService {
	public function __construct() {
		//
	}

	public static function get_tokenpass_login_url() {
		$settings = get_option( 'tokenpass_settings' );
		$client_id;
		if ( $settings ) {
			$client_id = $settings['client_id'] ?? null;
		}
		$redirect_uri = Router::get_route_url( 'authorize-callback' );
		$state = wp_generate_password();
		$url = add_query_arg( array(
			'client_id'     => $client_id,
			'redirect_uri'  => $redirect_uri,
			'scope'         => 'user',
			'response_type' => 'code',
			'state'         => $state,
		), 'https://tokenpass.tokenly.com/oauth/authorize' );
		return $url;
	}
}
