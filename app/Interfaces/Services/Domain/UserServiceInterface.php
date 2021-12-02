<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

interface UserServiceInterface {
	public function index( array $params );
	public function show( array $params );
	public function store( OauthUserInterface $oauth_user );
	public function add_view_inventory_user_action( array $actions, \WP_User $user );

}
