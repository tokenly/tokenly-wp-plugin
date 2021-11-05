<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\ConnectionView;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;

/**
 * Serves the admin Connection view
 */
class ConnectionController implements ConnectionControllerInterface {
	public $connection_view;
	public $auth_serivce;

	public function __construct(
		ConnectionView $connection_view,
		AuthServiceInterface $auth_serivce
	) {
		$this->connection_view = $connection_view;
		$this->auth_service = $auth_serivce;
	}

	public function show() {
		$user_id = get_current_user_id();
		$status = $this->auth_service->is_connected( $user_id );
		$render = $this->connection_view->render( array(
			'status' => $status,
		) );
		echo $render;
	}
}
