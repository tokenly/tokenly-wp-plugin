<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\PostRouteInterface;

class PostRoute extends Route implements PostRouteInterface {
	public ?array $post_type = null;
	public ?string $id = null;
	public ?string $title = null;
	public $show_callback = null;
	public $edit_callback = null;
	public $update_callback = null;

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'post_type',
			'id',
			'title',
			'show_callback',
			'edit_callback',
			'update_callback',
		) );
	}
}
