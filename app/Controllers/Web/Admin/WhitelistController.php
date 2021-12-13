<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\WhitelistViewModelInterface;
/**
 * Serves the admin Whitelist view
 */
class WhitelistController implements WhitelistControllerInterface {
	public $whitelist_view_model;

	public function __construct(
		WhitelistViewModelInterface $whitelist_view_model
	) {
		$this->whitelist_view_model = $whitelist_view_model;
	}

	public function show() {
		$view_data = $this->whitelist_view_model->prepare();
		return array(
			'view' => 'whitelist',
			'data' => $view_data,
		);
	}
}
