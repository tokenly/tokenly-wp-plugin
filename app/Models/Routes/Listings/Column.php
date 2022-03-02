<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ColumnInterface;

class Column extends Model implements ColumnInterface {
	protected ?string $id = null;
	protected ?string $title = null;
	protected ?array $data = null;
	protected mixed $callback;

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

	public function get_data(): ?array {
		return $this->data ?? null;
	}

	public function set_data( ?array $value ): void {
		$this->data = $value;
	}

	public function get_callback(): ?callable {
		return $this->callback ?? null;
	}

	public function set_callback( ?callable $value ): void {
		$this->callback = $value;
	}

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
