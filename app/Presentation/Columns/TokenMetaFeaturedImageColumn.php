<?php

namespace Tokenly\Wp\Presentation\Columns;

use Tokenly\Wp\Interfaces\Presentation\Columns\TokenMetaFeaturedImageColumnInterface;

class TokenMetaFeaturedImageColumn implements TokenMetaFeaturedImageColumnInterface {
	public string $root_url;

	public function __construct( string $root_url ) {
		$this->root_url = $root_url;
	}

	/**
	 * @inheritDoc
	 */
	public function column_callback( int $post_id ): array {
		$thumb_id = null;
		$thumb_url = null;
		$style_dir = get_stylesheet_directory_uri();
		$placeholder_url = "{$this->root_url}/resources/images/placeholder.png";
		$link = "/wp-admin/post.php?post={$post_id}&action=edit";
		if ( has_post_thumbnail( $post_id ) ) {
			$thumb_id = get_post_thumbnail_id( $post_id );
			if ( $thumb_id ) {
				$thumb_url = wp_get_attachment_url( $thumb_id );
			}
		}
		$column_data = array(
			'thumb_id'        => $thumb_id,
			'thumb_url'       => $thumb_url,
			'placeholder_url' => $placeholder_url,
			'link'            => $link,
		);
		return $column_data;
	}
}
