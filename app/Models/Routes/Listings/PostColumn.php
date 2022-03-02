<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Routes\Listings\Column;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\PostColumnInterface;

class PostColumn extends Column implements PostColumnInterface {
	protected ?array $post_type = null;

	public function get_post_type(): ?array {
		return $this->post_type ?? null;
	}

	public function set_post_type( ?array $value ): void {
		$this->post_type = $value;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'post_type',
		) );
	}
}
