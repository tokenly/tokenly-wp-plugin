<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\VendorControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Serves the admin Vendor view
 */
class VendorController implements VendorControllerInterface {
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
	}

	public function show(): array {
		return array(
			'view' => 'token-vendor',
		);
	}

	public function show_policy(): bool {
		$user = $this->user_repository->show_current();
		if ( $user ) {
			if ( user_can( $user, 'administrator' ) && $user->can_connect ) {
				return true;
			}
		}
		return false;
	}
}
