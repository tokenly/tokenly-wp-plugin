<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

class DashboardViewModel {
	protected $integration;
	protected $current_user;
	
	public function __construct(
		IntegrationInterface $integration,
		CurrentUserInterface $current_user
	) {
		$this->integration = $integration;
		$this->current_user = $current_user;
	}
	
	public function prepare( array $data = array() ) {
		return array(
			'is_admin'                => current_user_can( 'administrator' ),
			'integration_can_connect' => $this->integration->can_connect(),
			'user_can_connect'        => $this->current_user->can_connect(),
		);
	}
}
