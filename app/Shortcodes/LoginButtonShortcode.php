<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;

class LoginButtonShortcode extends Shortcode implements LoginButtonShortcodeInterface {
	protected $button_login_component;

	// public function __construct(
	// 	ButtonLoginComponentInterface $button_login_component
	// ) {
	// 	$this->button_login_component = $button_login_component;
	// }

	// public function shortcode_callback() {
	// 	return $this->button_login_component->render();
	// }
}
