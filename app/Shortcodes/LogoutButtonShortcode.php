<?php

namespace Tokenly\Wp\Shortcodes;

use Tokenly\Wp\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;

class LogoutButtonShortcode extends Shortcode implements LogoutButtonShortcodeInterface {
	protected $logout_button_component_model;

	public function __construct(
		LogoutButtonComponentModelInterface $logout_button_component_model
	) {
		$this->logout_button_component_model = $logout_button_component_model;
	}

	public function shortcode_callback() {
		$data = $this->logout_button_component_model->prepare();
		return array(
			'template' => 'shortcodes/LogoutButtonShortcode.twig',
			'data'     => $data,
		);
	}
}
