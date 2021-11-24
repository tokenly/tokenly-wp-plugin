<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\ConnectionView;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Serves the admin Connection view
 */
class ConnectionController implements ConnectionControllerInterface {
	public $connection_view;
	public $auth_serivce;
	protected $user_service;
	protected $current_user;

	public function __construct(
		ConnectionView $connection_view,
		AuthServiceInterface $auth_serivce,
		UserServiceInterface $user_service,
		CurrentUserInterface $current_user
	) {
		$this->connection_view = $connection_view;
		$this->auth_service = $auth_serivce;
		$this->user_service = $user_service;
		$this->current_user = $current_user;
	}

	public function show() {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$status = $this->current_user->can_connect();
		$oauth_user = $this->current_user->get_oauth_user();
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
		return $render;
	}
}
