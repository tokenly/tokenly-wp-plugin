<?php

namespace Tokenly\Wp\Presentation\Shortcodes;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\UserInfoShortcodeInterface;

use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;

class UserInfoShortcode extends Shortcode implements UserInfoShortcodeInterface {
	protected UserInfoBlockModelInterface $user_info_block_model;

	public function __construct(
		UserInfoBlockModelInterface $user_info_block_model
	) {
		$this->user_info_block_model = $user_info_block_model;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback( $atts = array(), $content = null, $tag = '' ): array {
		$data = $this->user_info_block_model->prepare( $atts );
		return array(
			'template' => 'shortcodes/UserInfoShortcode.twig',
			'data'     => $data,
		);
	}
}
