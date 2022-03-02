<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\PromiseControllerInterface;

/**
 * Serves the admin promise views
 */
class PromiseController implements PromiseControllerInterface {
	public function index(): array {
		return array(
			'view' => 'token-promise-index',
		);
	}

	public function show(): array {
		return array(
			'view' => 'token-promise-show',
		);
	}

	public function store(): array {
		return array(
			'view' => 'token-promise-store',
		);
	}

	public function edit(): array {
		return array(
			'view' => 'token-promise-edit',
		);
	}
}
