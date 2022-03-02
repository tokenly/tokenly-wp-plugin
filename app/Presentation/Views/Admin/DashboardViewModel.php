<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;

class DashboardViewModel extends DynamicViewModel implements DashboardViewModelInterface {
	protected UserRepositoryInterface $user_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected ?UserInterface $current_user;
	
	public function __construct(
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		UserRepositoryInterface $user_repository
	) {
		$this->integration_settings_repository = $integration_settings_repository;
		$this->integration_settings = $this->integration_settings_repository->show();
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
	}
	
	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		$view_data = array(
			'is_admin'                => current_user_can( 'administrator' ),
			'integration_can_connect' => $this->integration_settings->get_can_connect(),
		);
		if ( isset( $this->current_user ) && $this->current_user instanceof UserInterface ) {
			$view_data['user_can_connect'] = $this->current_user->get_can_connect();
		}
		return $view_data;
	}
}
