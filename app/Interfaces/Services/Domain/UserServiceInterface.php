<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

interface UserServiceInterface {
	public function add_view_inventory_user_action( array $actions, \WP_User $user );
	public function get_addresses( int $id, array $params = array() );
	public function get_balances( int $id, array $params = array() );
	public function can_connect( int $user_id );
	public function connect( int $user_id, OauthUserInterface $oauth_user, string $oauth_token );
	public function disconnect( int $id );
	public function get_oauth_user( int $id );
	public function get_oauth_token( int $id );
	public function index( array $params );
	public function show( array $params );
	public function store( OauthUserInterface $oauth_user );

}
