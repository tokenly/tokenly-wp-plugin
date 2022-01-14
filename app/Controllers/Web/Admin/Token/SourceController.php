<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\SourceControllerInterface;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	public function index() {
		return array(
			'view' => 'token-source-index',
		);
	}

	public function show() {
		return array(
			'view' => 'token-source-show',
		);
	}

	public function store() {
		return array(
			'view' => 'token-source-store',
		);
	}

	public function edit() {
		return array(
			'view' => 'token-source-edit',
		);
	}
}
