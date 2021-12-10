<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
use Twig\Environment;

/**
 * Registers shortcodes
 */
class ShortcodeServiceProvider extends ServiceProvider implements ShortcodeServiceProviderInterface {
	protected $namespace;
	protected $twig;

	public function __construct(
		string $namespace,
		LoginButtonShortcodeInterface $login_button_shortcode,
		LogoutButtonShortcodeInterface $logout_button_shortcode,
		Environment $twig
	) {
		$this->twig = $twig;
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
			$callable = array( $service, 'shortcode_callback' );
			add_shortcode( $name, array( $this, 'render_shortcode', $callable ) );
			$service->register();
		}
	}

	protected function render_shortcode( callable $callback ) {

	}
}
