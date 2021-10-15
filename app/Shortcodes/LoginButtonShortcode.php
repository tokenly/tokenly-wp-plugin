<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Routes\ApiRouter;

class LoginButtonShortcode {

	public $name = 'tokenpass_login';
	public $api_router;

	public function __construct() {
		$this->api_router = new ApiRouter();
	}

	public function render() {
		$url = $this->api_router->get_route_url( 'authorize' );
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
