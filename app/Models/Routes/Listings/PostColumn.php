<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Routes\Listings\Column;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\PostColumnInterface;

class PostColumn extends Column implements PostColumnInterface {
	public ?array $post_type = null;

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'post_type',
		) );
	}
}
