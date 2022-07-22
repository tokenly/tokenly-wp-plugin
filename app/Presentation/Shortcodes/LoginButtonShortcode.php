<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;

class LoginButtonShortcode extends Shortcode
	implements LoginButtonShortcodeInterface
{
	protected LoginButtonComponentModelInterface $login_button_component_model;

	public function __construct(
		LoginButtonComponentModelInterface $login_button_component_model
	) {
		$this->login_button_component_model = $login_button_component_model;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		$data = $this->login_button_component_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/LoginButtonShortcode.twig',
			'data'     => $data,
		);
	}
}
