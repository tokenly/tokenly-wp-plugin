<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;

class LoginButtonShortcode extends Shortcode implements LoginButtonShortcodeInterface {
	protected $login_button_component_model;

	public function __construct(
		LoginButtonComponentModelInterface $login_button_component_model
	) {
		$this->login_button_component_model = $login_button_component_model;
	}

	public function shortcode_callback() {
		$data = $this->login_button_component_model->prepare();
		return array(
			'template' => 'shortcodes/LoginButtonShortcode.twig',
			'data'     => $data,
		);
	}
}
