<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Tokenly\TokenpassClient\TokenpassAPI;

return array(
	Environment::class => function () {
		$loader = new FilesystemLoader( TOKENLY_PLUGIN_TEMPLATE_DIR );
		$twig = new Environment( $loader, array(
			// 'cache' => TOKENLY_PLUGIN_TEMPLATE_CACHE_DIR,
			'cache' => false,
		) );
		return $twig;
	},
	TokenpassAPI::class => function () {
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
		$redirect_uri = TOKENLY_PLUGIN_AUTH_REDIRECT_URI;
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
	},
);