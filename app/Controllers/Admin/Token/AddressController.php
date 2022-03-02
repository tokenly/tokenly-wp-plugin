<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\AddressControllerInterface;

/**
 * Serves the admin address views
 */
class AddressController implements AddressControllerInterface {
	public function index(): array {
		return array(
			'view' => 'token-address-index',
		);
	}
	public function show(): array {
		return array(
			'view' => 'token-address-show',
		);
	}
	public function edit(): array {
		return array(
			'view' => 'token-address-edit',
		);
	}
	public function store(): array {
		return array(
			'view' => 'token-address-store',
		);
	}
	public function verify(): array {
		return array(
			'view' => 'token-address-verify',
		);
	}
	public function balance_index(): array {
		return array(
			'view' => 'token-address-balance-index',
		);
	}
}
