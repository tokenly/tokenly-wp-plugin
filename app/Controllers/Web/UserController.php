<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\ViewModels\Web\UserViewModel;

/**
 * Serves the public user views
 */
class UserController implements UserControllerInterface {
	protected $namespace;
	protected $user_view_model;

	public function __construct(
		string $namespace,
		UserViewModel $user_view_model
	) {
		$this->namespace = $namespace;
		$this->user_view_model = $user_view_model;
	}
	
	/**
	 * Shows the local public Tokenpass user page with
	 * the user information and token inventory
	 * @return void
	 */
	public function show() {
		$user_id = get_query_var( "{$this->namespace}_user_id" );
		if ( !$user_id ) {
			return false;
		}
		$view_data = $this->user_view_model->prepare( array(
			'user_id' => $user_id,
		) );
		return array(
			'template' => 'User.twig',
			'data'     => $view_data,
		);
	}
}
