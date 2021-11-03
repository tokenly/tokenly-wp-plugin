<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Controllers\Web\WebController;
use Tokenly\Wp\Views\Admin\DashboardView;

/**
 * Serves the admin Dashboard view
 */
class DashboardController extends WebController {
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
