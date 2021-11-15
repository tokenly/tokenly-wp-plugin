<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\ConnectionView;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Serves the admin Connection view
 */
class ConnectionController implements ConnectionControllerInterface {
	public $connection_view;
	public $auth_serivce;
	protected $user_repository;

	public function __construct(
		ConnectionView $connection_view,
		AuthServiceInterface $auth_serivce,
		UserRepositoryInterface $user_repository
	) {
		$this->connection_view = $connection_view;
		$this->auth_service = $auth_serivce;
		$this->user_repository = $user_repository;
	}

	public function show() {
		$user_id = get_current_user_id();
		$user = $this->user_repository->show( array(
			'id' => $user_id,
		) );
		$status = $user->is_connected();
		$oauth_user = $user->get_oauth_user();
		$user_data = null;
		if ( $oauth_user ) {
			$user_data = array(
				'name'     => $oauth_user->name,
				'username' => $oauth_user->username,
			);
		}
		$render = $this->connection_view->render( array(
			'status' => $status,
			'user'   => $user_data,
		) );
		echo $render;
	}
}
