<?php

namespace Tokenly\Wp\Policies\Admin;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\UserPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class UserPolicy extends Policy implements UserPolicyInterface {
	protected UserRepositoryInterface $user_repository;
	protected ?UserInterface $user;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
		$this->user = $this->user_repository->show_current();
	}

	public function credit_balance_index() {
		return false;
	}

	public function token_balance_index() {
		return false;
	}

	public function before() {
		if (
			$this->user &&
			$this->user->can_connect
		) {
			return true;
		}
		return false;
	}
}
