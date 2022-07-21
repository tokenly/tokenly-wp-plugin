<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ColumnInterface;

class Column extends Model implements ColumnInterface {
	public ?string $id = null;
	public ?string $title = null;
	public ?array $data = null;
	public mixed $callback = null;

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'id',
			'title',
			'data',
			'callback',
		) );
	}
}
