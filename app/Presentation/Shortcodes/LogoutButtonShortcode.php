<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;

class LogoutButtonShortcode extends Shortcode
	implements LogoutButtonShortcodeInterface
{
	protected LogoutButtonComponentModelInterface $logout_button_component_model;

	public function __construct(
		LogoutButtonComponentModelInterface $logout_button_component_model
	) {
		$this->logout_button_component_model = $logout_button_component_model;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		$data = $this->logout_button_component_model->prepare();
		return array(
			'template' => 'shortcodes/LogoutButtonShortcode.twig',
			'data'     => $data,
		);
	}
}
