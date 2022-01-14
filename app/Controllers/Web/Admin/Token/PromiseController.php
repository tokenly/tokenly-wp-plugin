<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\PromiseControllerInterface;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	public function show() {
		return array(
			'view' => 'token-promise-show',
		);
	}

	public function store() {
		return array(
			'view' => 'token-promise-store',
		);
	}

	public function edit() {
		return array(
			'view' => 'token-promise-edit',
		);
	}
}
