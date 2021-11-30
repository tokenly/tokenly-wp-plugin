<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Shortcodes\LogoutButtonShortcode;

/**
 * Registers shortcodes
 */
class ShortcodeServiceProvider extends ServiceProvider implements ShortcodeServiceProviderInterface {
	protected $namespace;

	public function __construct(
		LoginButtonShortcode $login_button_shortcode,
		LogoutButtonShortcode $logout_button_shortcode,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->services = array(
			'login'  => $login_button_shortcode,
			'logout' => $logout_button_shortcode,
		);
	}

	/**
	 * Registers the services
	 * @return void
	 */
	public function register() {
		foreach ( $this->services as $key => $service ) {
			$name = "{$this->namespace}_{$key}";
			add_shortcode( $name, array( $service, 'shortcode_callback' ) );
			$service->register();
		}
	}
}
