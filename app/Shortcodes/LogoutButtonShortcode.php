<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;

class LogoutButtonShortcode extends Shortcode implements LogoutButtonShortcodeInterface {
	protected $logout_button_component_model;

	public function __construct(
		ButtonLogoutComponentInterface $logout_button_component_model
	) {
		$this->logout_button_component_model = $logout_button_component_model;
	}

	public function shortcode_callback() {
		$data = $this->logout_button_component_model->prepare();
		return array(
			'template' => 'components/LoginButtonComponent.twig',
			'data'     => $data,
		);
	}
}
