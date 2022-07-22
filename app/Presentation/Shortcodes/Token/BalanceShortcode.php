<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\BalanceShortcodeInterface;

class BalanceShortcode extends Shortcode implements BalanceShortcodeInterface {
	protected string $namespace;

	public function __construct(
		string $namespace
	) {
		$this->namespace = $namespace;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		$atts[ 'namespace' ] = $this->namespace;
		return array(
			'template' => 'shortcodes/Token/BalanceShortcode.twig',
			'data'     => $atts,
		);
	}
}
