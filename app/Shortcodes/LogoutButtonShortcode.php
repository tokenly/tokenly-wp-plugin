<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Interfaces\Components\ButtonLogoutComponentInterface;
use Tokenly\Wp\Shortcodes\Shortcode;

class LogoutButtonShortcode extends Shortcode {
	protected $button_logout_component;

	public function __construct(
		ButtonLogoutComponentInterface $button_logout_component
	) {
		$this->button_logout_component = $button_logout_component;
	}

	public function shortcode_callback() {
		$render = parent::shortcode_callback();
		return $this->button_logout_component->render();
	}
}
