<?php

namespace Tokenly\Wp\Models\Routes\Listings;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ActionInterface;

class Action extends Model implements ActionInterface {
	public ?string $title = null;
	public ?string $url = null;

	public function get_html(): string {
		$url = $this->url;
		$title = $this->title;
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
