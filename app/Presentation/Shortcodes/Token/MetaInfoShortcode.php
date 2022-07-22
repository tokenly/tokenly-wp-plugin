<?php

namespace Tokenly\Wp\Presentation\Shortcodes\Token;

use Tokenly\Wp\Presentation\Shortcodes\Shortcode;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaInfoShortcodeInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;

class MetaInfoShortcode extends Shortcode
	implements MetaInfoShortcodeInterface
{
	protected string $fallback_image;
	protected MetaRepositoryInterface $meta_repository;
	protected CategoryTermRepositoryInterface $category_term_repository;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		string $fallback_image,
		MetaRepositoryInterface $meta_repository,
		CategoryTermRepositoryInterface $category_term_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->fallback_image = $fallback_image;
		$this->meta_repository = $meta_repository;
		$this->category_term_repository = $category_term_repository;
		$this->user_repository = $user_repository;
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
			$post = 
				$this->category_term_repository->apply_meta_fallback_single(
					$post
				);
			if ( $post ) {
				$post = $post->to_array();
				if ( !$post['image'] || $post['image'] == false ) {
					$post['image'] = $this->fallback_image;
				}
				$atts['post'] = $post;
			}
			$terms = $this->category_term_repository->index( array(
				'id' => $atts['id'],
			) );
			if ( $terms ) {
				$terms = $terms->to_array();
				$atts['terms'] = $terms;
			}
			$user = $this->user_repository->show_current();
			if ( $user ) {
				$user = $user->to_array();
				$atts['user'] = $user;
			}
		}
		return array(
			'template' => 'shortcodes/Token/MetaInfoShortcode.twig',
			'data'     => $atts,
		);
	}
}
