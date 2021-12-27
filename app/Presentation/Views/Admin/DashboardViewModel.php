<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;

use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

class DashboardViewModel extends DynamicViewModel implements DashboardViewModelInterface {
	protected $integration;
	protected $current_user;
	
	public function __construct(
		IntegrationInterface $integration,
		CurrentUserInterface $current_user
	) {
		$this->integration = $integration;
		$this->current_user = $current_user;
	}
	
	protected function get_view_props( array $data = array() ) {
		return array(
			'is_admin'                => current_user_can( 'administrator' ),
			'integration_can_connect' => $this->integration->can_connect(),
			'user_can_connect'        => $this->current_user->can_connect(),
		);
	}
}
