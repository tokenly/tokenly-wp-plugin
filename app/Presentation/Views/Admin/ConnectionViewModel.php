<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\ConnectionViewModelInterface;

use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class ConnectionViewModel extends DynamicViewModel implements ConnectionViewModelInterface {
	protected $current_user;
	
	public function __construct(
		CurrentUserInterface $current_user
	) {
		$this->current_user = $current_user;
	}
	
	protected function get_view_props( array $data = array() ) {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		$status = $this->current_user->can_connect();
		$this->current_user->load( array( 'oauth_user' ) );
		$oauth_user = $this->current_user->oauth_user;
		$user_data = null;
		if ( $oauth_user ) {
			$user_data = array(
				'name'     => $oauth_user->name,
				'username' => $oauth_user->username,
			);
		}
		return array(
			'status' => $status,
			'user'   => $user_data,
		);
	}
}
