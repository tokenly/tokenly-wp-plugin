<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\DashboardView;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;

/**
 * Serves the admin Dashboard view
 */
class DashboardController implements DashboardControllerInterface {
	public $dashboard_view;

	public function __construct(
		DashboardView $dashboard_view
	) {
		$this->dashboard_view = $dashboard_view;
	}

	public function show() {
		$render = $this->dashboard_view->render( array(
			//
		) );
		echo $render;
	}
}
