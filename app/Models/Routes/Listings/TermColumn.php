<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Routes\Listings\Column;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\TermColumnInterface;

class TermColumn extends Column implements TermColumnInterface {
	protected ?array $taxonomy = null;

	public function get_taxonomy(): ?array {
		return $this->taxonomy ?? null;
	}

	public function set_taxonomy( ?array $value ): void {
		$this->taxonomy = $value;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'taxonomy',
		) );
	}
}
