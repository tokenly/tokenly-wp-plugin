<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\PostRouteInterface;

class PostRoute extends Route implements PostRouteInterface {
	protected ?array $post_type = null;
	protected ?string $id = null;
	protected ?string $title = null;
	protected mixed $show_callback;
	protected mixed $edit_callback;
	protected mixed $update_callback;
	
	public function get_post_type(): ?array {
		return $this->post_type ?? null;
	}

	public function set_post_type( ?array $value ): void {
		$this->post_type = $value;
	}

	public function get_id(): ?string {
		return $this->id ?? null;
	}

	public function set_id( ?string $value ): void {
		$this->id = $value;
	}

	public function get_title(): ?string {
		return $this->title ?? null;
	}

	public function set_title( ?string $value ): void {
		$this->title = $value;
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
			'post_type',
			'id',
			'title',
			'show_callback',
			'edit_callback',
			'update_callback',
		) );
	}
}
