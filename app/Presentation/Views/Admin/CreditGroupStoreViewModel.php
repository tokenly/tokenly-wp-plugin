<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class CreditGroupStoreViewModel extends ViewModel implements CreditGroupStoreViewModelInterface {
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
