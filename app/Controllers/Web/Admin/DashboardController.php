<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\ViewModels\Admin\DashboardViewModel;

/**
 * Serves the admin Dashboard view
 */
class DashboardController implements DashboardControllerInterface {
	protected $dashboard_view_model;

	public function __construct(
		DashboardViewModel $dashboard_view_model
	) {
		$this->dashboard_view_model = $dashboard_view_model;
	}

	public function show() {
		$view_data = $this->dashboard_view_model->prepare();
		return $view_data;
	}
}
