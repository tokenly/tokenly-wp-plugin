<?php

namespace Tokenly\Wp\Controllers\Admin;

use Tokenly\Wp\Interfaces\Controllers\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;

/**
 * Serves the admin Dashboard view
 */
class DashboardController implements DashboardControllerInterface {
	protected DashboardViewModelInterface $dashboard_view_model;

	public function __construct(
		DashboardViewModelInterface $dashboard_view_model
	) {
		$this->dashboard_view_model = $dashboard_view_model;
	}

	public function show(): array {
		$view_data = $this->dashboard_view_model->prepare();
		return array(
			'view' => 'dashboard',
			'data' => $view_data,
		);
	}
}
