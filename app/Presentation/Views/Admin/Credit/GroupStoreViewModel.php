<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;

class GroupStoreViewModel extends DynamicViewModel
	implements GroupStoreViewModelInterface
{
	protected IntegrationSettingsInterface $integration_settings;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	
	public function __construct(
		IntegrationSettingsRepositoryInterface $integration_settings_repository
	) {
		$this->integration_settings_repository = 
			$integration_settings_repository;
		$this->integration_settings = 
			$this->integration_settings_repository->show();
	}
	
	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		return array(
			'client_id' => $this->integration_settings->client_id,
		);
	}
}
