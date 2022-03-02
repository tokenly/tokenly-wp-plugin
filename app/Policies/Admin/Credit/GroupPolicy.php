<?php

namespace Tokenly\Wp\Policies\Admin\Credit;

use Tokenly\Wp\Policies\Policy;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\GroupPolicyInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class GroupPolicy extends Policy implements GroupPolicyInterface {
	protected UserRepositoryInterface $user_repository;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected ?UserInterface $user;

	public function __construct(
		UserRepositoryInterface $user_repository,
		IntegrationSettingsRepositoryInterface $integration_settings_repository
	) {
		$this->integration_settings_repository = $integration_settings_repository;
		$this->integration_settings = $this->integration_settings_repository->show();
		$this->user_repository = $user_repository;
		$this->user = $this->user_repository->show_current();
	}

	public function index(): bool {
		if (
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			user_can( $this->user, 'administrator' )
		) {
			
			return true;
		}
		return false;
	}

	public function show(): bool {
		if ( 
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}

	public function store(): bool {
		if (
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			$this->user->get_can_connect() &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}

	public function edit(): bool {
		if (
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			$this->user->get_can_connect() &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}

	public function account_index(): bool {
		if (
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			$this->user->get_can_connect() &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}

	public function whitelist_edit(): bool {
		return true;
		if (
			$this->integration_settings->get_can_connect() &&
			$this->user &&
			user_can( $this->user, 'administrator' )
		) {
			return true;
		}
		return false;
	}
}
