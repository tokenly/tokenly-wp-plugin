<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\AdminRouteInterface;

use Tokenly\Wp\Collections\Routes\AdminRouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\AdminRouteCollectionInterface;

class AdminRoute extends Route implements AdminRouteInterface {
	public ?string $parent_slug = null;
	public ?string $page_title = null;
	public ?string $menu_title = null;
	public ?string $menu_slug = null;
	public mixed $callable;
	public mixed $policy;
	public ?string $capability = null;
	public ?string $icon_url = null;
	public AdminRouteCollectionInterface $subroutes;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['subroutes'] ) && is_array( $data['subroutes'] ) ) {
			$data['subroutes'] = ( new AdminRouteCollection() )->from_array( $data['subroutes'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'parent_slug',
			'page_title',
			'menu_title',
			'menu_slug',
			'callable',
			'policy',
			'capability',
			'icon_url',
			'position',
			'subroutes',
		) );
	}
}
