<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLogoutComponentInterface;

class LogoutButtonShortcode extends Shortcode implements LogoutButtonShortcodeInterface {
	protected $button_logout_component;

	public function __construct(
		ButtonLogoutComponentInterface $button_logout_component
	) {
		$this->button_logout_component = $button_logout_component;
	}

	public function shortcode_callback() {
		return $this->button_logout_component->render();
	}
}
