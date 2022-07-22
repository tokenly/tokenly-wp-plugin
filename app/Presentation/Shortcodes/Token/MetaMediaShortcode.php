<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaMediaShortcodeInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

class MetaMediaShortcode extends Shortcode
	implements MetaMediaShortcodeInterface
{
	protected MetaRepositoryInterface $meta_repository;

	public function __construct(
		MetaRepositoryInterface $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function shortcode_callback(
		$atts = array(), $content = null, $tag = ''
	): array {
		if ( isset( $atts['id'] ) ) {
			$post = $this->meta_repository->show( array(
				'id' => $atts['id'],
			) );
			if ( $post ) {
				$post = $post->to_array();
				$atts['media'] = $post['media'];
			}
		}
		return array(
			'template' => 'shortcodes/Token/MetaMediaShortcode.twig',
			'data'     => $atts,
		);
	}
}
