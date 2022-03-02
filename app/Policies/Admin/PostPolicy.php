<?php

namespace Tokenly\Wp\Policies\Admin;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\PostPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class PostPolicy extends Policy implements PostPolicyInterface {
	protected UserRepositoryInterface $user_repository;
	protected ?UserInterface $user;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
		$this->user = $this->user_repository->show_current();
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
