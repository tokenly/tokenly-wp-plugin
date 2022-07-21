<?php

namespace Tokenly\Wp\Policies\Admin\Token;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\AddressPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class AddressPolicy extends Policy implements AddressPolicyInterface {
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

	public function index() {
		return false;
	}

	public function show() {
		return false;
	}

	public function store() {
		return false;
	}

	public function edit() {
		return false;
	}

	public function verify() {
		return false;
	}

	public function balance_index() {
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
