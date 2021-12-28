<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class DashboardViewModel extends DynamicViewModel implements DashboardViewModelInterface {
	protected $integration;
	protected $user_service;
	protected $current_user;
	
	public function __construct(
		IntegrationInterface $integration,
		UserServiceInterface $user_service
	) {
		$this->integration = $integration;
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
	}
	
	protected function get_view_props( array $data = array() ) {
		$view_data = array(
			'is_admin'                => current_user_can( 'administrator' ),
			'integration_can_connect' => $this->integration->can_connect(),
		);
		if ( isset( $this->current_user ) && $this->current_user instanceof UserInterface ) {
			$view_data['user_can_connect'] = $this->current_user->can_connect();
		}
		return $view_data;
	}
}
