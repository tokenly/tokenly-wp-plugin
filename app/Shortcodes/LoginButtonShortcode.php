<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Router;

class LoginButtonShortcode {

	public $name = 'tokenpass_login';
	public $router;

	public function __construct() {
		$this->router = new Router;
	}

	public function render() {
		$url = $this->router->get_route_url( 'authorize' );
		return "
			<div class='tokenpass-login-container'>
				<a href='{$url}' class='button tokenpass-login'>Login with Tokenpass</a>
			</div>";
	}

	public static function shortcode_callback() {
		$shortcode = new self();
		return $shortcode->render();
	}
}
