<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;

/**
 * Serves the public user views
 */
class UserController implements UserControllerInterface {
	protected string $namespace;
	protected UserViewModelInterface $user_view_model;

	public function __construct(
		string $namespace,
		UserViewModelInterface $user_view_model
	) {
		$this->namespace = $namespace;
		$this->user_view_model = $user_view_model;
	}
	
	/**
	 * Shows the local public Tokenpass user page with
	 * the user information and token inventory
	 * @return void
	 */
	public function show(): array {
		$user = get_query_var( "{$this->namespace}_user" );
		if ( !$user ) {
			return false;
		}
		$view_data = $this->user_view_model->prepare( array(
			'user_id' => $user,
		) );
		return array(
			'template' => 'User.twig',
			'data'     => $view_data,
		);
	}
}
