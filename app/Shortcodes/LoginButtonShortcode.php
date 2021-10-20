<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Components\ButtonLoginComponent;

class LoginButtonShortcode {
	public $name = 'tokenpass_login';
	public $button_login_component;

	public function __construct( ButtonLoginComponent $button_login_component ) {
		$this->button_login_component = $button_login_component;
	}

	public function shortcode_callback() {
		return $this->button_login_component->render();
	}
}
