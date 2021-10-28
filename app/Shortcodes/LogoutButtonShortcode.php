<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Components\ButtonLogoutComponent;

class LogoutButtonShortcode {
	public $button_logout_component;

	public function __construct(
		ButtonLogoutComponent $button_logout_component
	) {
		$this->button_logout_component = $button_logout_component;
	}

	public function shortcode_callback() {
		return $this->button_logout_component->render();
	}
}
