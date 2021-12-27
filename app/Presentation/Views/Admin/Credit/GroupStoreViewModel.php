<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class GroupStoreViewModel extends DynamicViewModel implements GroupStoreViewModelInterface {
	protected $integration_settings;
	
	public function __construct(
		IntegrationSettingsInterface $integration_settings
	) {
		$this->integration_settings = $integration_settings;
	}
	
	protected function get_view_props( array $data = array() ) {
		return array(
			'client_id' => $this->integration_settings->client_id,
		);
	}
}
