<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;
use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Services\ClientService;

class Bootstrap {
	private $container;
	private $providers;

	public function __construct() {
		$this->container = $this->build_container();
		$this->register_providers();
	}

	public function get_providers() {
		return array(
			AppServiceProvider::class,
			RouteServiceProvider::class,
			ShortcodeServiceProvider::class
		);
	}

	public function register_providers() {
		$this->providers = $this->get_providers();
		foreach ( $this->providers as $provider ) {
			$provider = $this->container->get( $provider );
			$provider->register();
		}
	}

	public function build_container() {
		$builder = new \DI\ContainerBuilder();
		$builder->useAnnotations( true );
		$builder->addDefinitions( $this->get_bindings() );
		$container = $builder->build();
		return $container;
	}

	public function get_bindings() {
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
	}
}
