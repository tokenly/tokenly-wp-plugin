<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;

/**
 * Serves the admin Connection view
 */
class ConnectionController implements ConnectionControllerInterface {
	public function show() {
		return array(
			'view' => 'connection',
		);
	}
}
