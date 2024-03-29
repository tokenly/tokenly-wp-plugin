<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\TermRouteInterface;

class TermRoute extends Route implements TermRouteInterface {
	public ?string $id = null;
	public ?array $taxonomy = null;
	public $edit_callback = null;
	public $update_callback = null;
	public $show_callback = null;

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'id',
			'taxonomy',
			'show_callback',
			'edit_callback',
			'update_callback',
		) );
	}
}
