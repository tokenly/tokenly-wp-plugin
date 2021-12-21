<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\AppCreditInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\TokenInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\UserInfoShortcodeInterface;
use Twig\Environment;

/**
 * Registers shortcodes
 */
class ShortcodeServiceProvider extends ServiceProvider implements ShortcodeServiceProviderInterface {
	protected $namespace;
	protected $twig;

	public function __construct(
		string $namespace,
		AppCreditInventoryShortcodeInterface $app_credit_inventory_shortcode,
		LoginButtonShortcodeInterface $login_button_shortcode,
		LogoutButtonShortcodeInterface $logout_button_shortcode,
		TokenInventoryShortcodeInterface $token_inventory_shortcode,
		UserInfoShortcodeInterface $user_info_shortcode,
		Environment $twig
	) {
		$this->twig = $twig;
		$this->namespace = $namespace;
		$this->services = array(
			'app_credit_inventory'  => $app_credit_inventory_shortcode,
			'login'                 => $login_button_shortcode,
			'logout'                => $logout_button_shortcode,
			'token_inventory'       => $token_inventory_shortcode,
			'user_info'             => $user_info_shortcode
		);
	}

	/**
	 * Registers the services
	 * @return void
	 */
	public function register() {
		foreach ( $this->services as $key => $service ) {
			$name = "{$this->namespace}_{$key}";
			add_shortcode( $name, function(  $atts = array(), $content = null, $tag = ''  ) use ( $service ) {
				if ( !is_array( $atts ) ) {
					$atts = array();
				}
				$response = $service->shortcode_callback( $atts, $content, $tag );
				return $this->render_shortcode( $response );
			} );
			$service->register();
		}
	}

	/**
	 * Renders the shortcode using the specified parameters
	 * @param array $parameters Shortcode parameters
	 * @return string
	 */
	protected function render_shortcode( array $parameters ) {
		$template = $parameters['template'];
		$data = array();
		if ( isset( $parameters['data'] ) ) {
			$data = $parameters['data'];
		}
		$html = $this->twig->render( $template, $data );
		return $html;
	}
}
