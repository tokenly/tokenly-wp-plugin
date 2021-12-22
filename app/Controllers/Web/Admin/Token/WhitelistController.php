<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface;
/**
 * Serves the admin Whitelist view
 */
class WhitelistController implements WhitelistControllerInterface {
	public $edit_view_model;

	public function __construct(
		WhitelistEditViewModelInterface $edit_view_model
	) {
		$this->edit_view_model = $edit_view_model;
	}

	public function edit() {
		$view_data = $this->edit_view_model->prepare();
		return array(
			'view' => 'token-whitelist-edit',
			'data' => $view_data,
		);
	}
}
