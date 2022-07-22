<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaAttributesShortcodeInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

class MetaAttributesShortcode extends Shortcode
	implements MetaAttributesShortcodeInterface
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
				$atts['attributes'] = $post['attributes'];
			}
		}
		return array(
			'template' => 'shortcodes/Token/MetaAttributesShortcode.twig',
			'data'     => $atts,
		);
	}
}
