<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Routes\Listings\Column;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\TermColumnInterface;

class TermColumn extends Column implements TermColumnInterface {
	public ?array $taxonomy = null;

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'taxonomy',
		) );
	}
}
