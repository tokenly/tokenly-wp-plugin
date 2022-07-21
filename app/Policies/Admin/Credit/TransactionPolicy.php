<?php

namespace Tokenly\Wp\Policies\Admin\Credit;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\TransactionPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class TransactionPolicy extends Policy implements TransactionPolicyInterface {
	protected UserRepositoryInterface $user_repository;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected ?UserInterface $user;

	public function __construct(
		UserRepositoryInterface $user_repository,
		IntegrationSettingsRepositoryInterface $integration_settings_repository
	) {
		$this->user_repository = $user_repository;
		$this->user = $this->user_repository->show_current();
		$this->integration_settings_repository =
			$integration_settings_repository;
		$this->integration_settings =
			$this->integration_settings_repository->show();
	}

	public function index(): bool {
		return false;
	}

	public function store(): bool {
		return false;
	}

	public function before(): bool {
		if (
			$this->user &&
			$this->user->can_connect &&
			$this->integration_settings->can_connect &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}
}
