<?php

use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;

return function(
		string $namespace,
		UserControllerInterface $user_controller,	
		AuthControllerInterface $auth_controller,
		PostControllerInterface $post_controller
	) {
	return array(
		array(
			'id'        => 'user',
			'path'      => 'user/{user}',
			'callback'  => array( $user_controller, 'show' ),
		),
		array(
			'id'        => 'user_me',
			'path'      => 'user/me',
			'callback'	=> array( $auth_controller, 'show' ),
		),
		array(
			'id'        => 'oauth_callback',
			'path'      => 'oauth/callback',
			'callback'	=> array( $auth_controller, 'callback' ),
		),
		array(
			'id'        => 'oauth_connect',
			'path'      => 'oauth/connect',
			'callback'	=> array( $auth_controller, 'store' ),
		),
		array(
			'id'        => 'oauth_disconnect',
			'path'      => 'oauth/disconnect',
			'callback'	=> array( $auth_controller, 'destroy' ),
		),
		array(
			'id'        => 'access_denied',
			'path'      => 'access-denied',
			'callback'	=> array( $post_controller, 'denied' ),
		),
	);
};
