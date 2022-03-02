<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\TermRouteInterface;

class TermRoute extends Route implements TermRouteInterface {
	protected ?string $id = null;
	protected ?array $taxonomy = null;
	protected mixed $edit_callback;
	protected mixed $update_callback;

	public function get_id(): ?string {
		return $this->id ?? null;
	}

	public function set_id( ?string $value ): void {
		$this->id = $value;
	}
	
	public function get_taxonomy(): ?array {
		return $this->taxonomy ?? null;
	}

	public function set_taxonomy( ?array $value ): void {
		$this->taxonomy = $value;
	}

	public function get_show_callback(): ?callable {
		return $this->show_callback ?? null;
	}

	public function set_show_callback( ?callable $value ): void {
		$this->show_callback = $value;
	}

	public function get_edit_callback(): ?callable {
		return $this->edit_callback ?? null;
	}

	public function set_edit_callback( ?callable $value ): void {
		$this->edit_callback = $value;
	}

	public function get_update_callback(): ?callable {
		return $this->update_callback ?? null;
	}

	public function set_update_callback( ?callable $value ): void {
		$this->update_callback = $value;
	}

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
