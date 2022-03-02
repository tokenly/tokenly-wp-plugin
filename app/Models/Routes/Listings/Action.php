<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ActionInterface;

class Action extends Model implements ActionInterface {
	protected ?string $title = null;
	protected ?string $url = null;

	public function get_title(): ?string {
		return $this->title ?? null;
	}

	public function set_title( ?string $value ): void {
		$this->title = $value;
	}

	public function get_url(): ?string {
		return $this->url ?? null;
	}

	public function set_url( ?string $value ): void {
		$this->url = $value;
	}

	public function get_html(): string {
		$url = $this->get_url();
		$title = $this->get_title();
		return "<a href='{$url}'>{$title}</a>";
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'title',
			'url',
		) );
	}
}
