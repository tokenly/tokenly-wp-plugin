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
			add_shortcode( $name, function() use ( $service ) {
				$response = $service->shortcode_callback();
				$this->render_shortcode( $response );
			} );
			$service->register();
		}
	}

	protected function render_shortcode( array $parameters ) {
		$template = $parameters['template'];
		$data = array();
		if ( isset( $parameters['data'] ) ) {
			$data = $parameters['data'];
		}
		$html = $this->twig->render( $template, $data );
		echo $html;
	}
}
