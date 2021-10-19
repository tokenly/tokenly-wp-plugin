<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Components\ButtonLoginComponent;

class LoginButtonShortcode {
	public $name = 'tokenpass_login';

	public function shortcode_callback() {
		$component = new ButtonLoginComponent();
		return $component->render();
	}
}
