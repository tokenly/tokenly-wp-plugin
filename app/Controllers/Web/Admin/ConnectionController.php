<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\ViewModels\Admin\ConnectionViewModel;

/**
 * Serves the admin Connection view
 */
class ConnectionController implements ConnectionControllerInterface {
	protected $connection_view_model;

	public function __construct(
		ConnectionViewModel $connection_view_model
	) {
		$this->connection_view_model = $connection_view_model;
	}

	public function show() {
		$view_data = $this->connection_view_model->prepare();
		return $view_data;
	}
}
