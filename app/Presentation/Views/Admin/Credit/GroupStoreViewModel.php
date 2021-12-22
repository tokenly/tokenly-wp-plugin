<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class GroupStoreViewModel extends ViewModel implements GroupStoreViewModelInterface {
	protected $integration_settings;
	
	public function __construct(
		IntegrationSettingsInterface $integration_settings
	) {
		$this->integration_settings = $integration_settings;
	}
	
	public function prepare( array $data = array() ) {
		return array(
			'client_id' => $this->integration_settings->client_id,
		);
	}
}
