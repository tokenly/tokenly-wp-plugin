<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\DashboardView;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

/**
 * Serves the admin Dashboard view
 */
class DashboardController implements DashboardControllerInterface {
	protected $dashboard_view;
	protected $integration;
	protected $current_user;

	public function __construct(
		DashboardView $dashboard_view,
		IntegrationInterface $integration,
		CurrentUserInterface $current_user
	) {
		$this->dashboard_view = $dashboard_view;
		$this->integration = $integration;
		$this->current_user = $current_user;
	}

	public function show() {
		$render = $this->dashboard_view->render( array(
			'integration_can_connect' => $this->integration->can_connect(),
			'user_can_connect'        => $this->current_user->can_connect(),
		) );
		return $render;
	}
}
