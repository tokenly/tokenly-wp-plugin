<?php

namespace Tokenly\Wp\Policies\Admin\Token;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\WhitelistPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class WhitelistPolicy extends Policy implements WhitelistPolicyInterface {
	protected UserRepositoryInterface $user_repository;
	protected ?UserInterface $user;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
		$this->user = $this->user_repository->show_current();
	}

	public function edit() {
		return false;
	}

	public function before() {
		if (
			$this->user &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}
}
