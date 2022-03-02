<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\AdminRouteInterface;

use Tokenly\Wp\Collections\Routes\AdminRouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\AdminRouteCollectionInterface;

class AdminRoute extends Route implements AdminRouteInterface {
	protected ?string $parent_slug = null;
	protected ?string $page_title = null;
	protected ?string $menu_title = null;
	protected ?string $menu_slug = null;
	protected mixed $callable;
	protected mixed $policy;
	protected ?string $capability = null;
	protected ?string $icon_url = null;
	protected AdminRouteCollectionInterface $subroutes;

	public function get_parent_slug(): ?string {
		return $this->parent_slug ?? null;
	}

	public function set_parent_slug( ?string $value ): void {
		$this->parent_slug = $value;
	}

	public function get_page_title(): ?string {
		return $this->page_title ?? null;
	}

	public function set_page_title( ?string $value ): void {
		$this->page_title = $value;
	}

	public function get_menu_title(): ?string {
		return $this->menu_title ?? null;
	}

	public function set_menu_title( ?string $value ): void {
		$this->menu_title = $value;
	}

	public function get_menu_slug(): ?string {
		return $this->menu_slug ?? null;
	}

	public function set_menu_slug( ?string $value ): void {
		$this->menu_slug = $value;
	}

	public function get_callable(): ?callable {
		return $this->callable ?? null;
	}

	public function set_callable( ?callable $value ): void {
		$this->callable = $value;
	}

	public function get_policy(): ?callable {
		return $this->policy ?? null;
	}

	public function set_policy( ?callable $value ): void {
		$this->policy = $value;
	}

	public function get_capability(): ?string {
		return $this->capability ?? null;
	}

	public function set_capability( ?string $value ): void {
		$this->capability = $value;
	}

	public function get_icon_url(): ?string {
		return $this->icon_url ?? null;
	}

	public function set_icon_url( ?string $value ): void {
		$this->icon_url = $value;
	}

	public function get_position(): ?int {
		return $this->position ?? null;
	}

	public function set_position( ?int $value ): void {
		$this->position = $value;
	}

	public function get_subroutes(): ?AdminRouteCollectionInterface {
		return $this->subroutes ?? null; 
	}

	public function set_subroutes( ?AdminRouteCollectionInterface $value ): void {
		$this->subroutes = $value;
	}

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
