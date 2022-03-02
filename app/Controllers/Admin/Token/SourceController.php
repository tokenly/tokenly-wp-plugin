<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\SourceControllerInterface;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	public function index(): array {
		return array(
			'view' => 'token-source-index',
		);
	}

	public function show(): array {
		return array(
			'view' => 'token-source-show',
		);
	}

	public function store(): array {
		return array(
			'view' => 'token-source-store',
		);
	}

	public function edit(): array {
		return array(
			'view' => 'token-source-edit',
		);
	}
}
