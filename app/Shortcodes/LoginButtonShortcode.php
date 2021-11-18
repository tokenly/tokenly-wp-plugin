<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Components\ButtonLoginComponent;
use Tokenly\Wp\Shortcodes\Shortcode;

class LoginButtonShortcode extends Shortcode {
	protected $button_login_component;

	public function __construct(
		ButtonLoginComponent $button_login_component
	) {
		$this->button_login_component = $button_login_component;
	}

	public function shortcode_callback() {
		return $this->button_login_component->render();
	}
}
