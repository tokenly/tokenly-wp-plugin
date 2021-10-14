<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Services\TokenlyService;

class LoginButtonShortcode {

	public static $name = 'tokenpass_login';

	public function __construct() {
		//
	}

	public function render() {
		$url = TokenlyService::get_tokenpass_login_url();
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
