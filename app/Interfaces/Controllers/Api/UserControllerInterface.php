<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

interface UserControllerInterface extends ControllerInterface {
	public function index( UserCollectionInterface $users, \WP_REST_Request $request );
	public function show( UserInterface $user, \WP_REST_Request $request );
	public function credit_balance_index( UserInterface $user, \WP_REST_Request $request );
	public function token_balance_index( UserInterface $user, \WP_REST_Request $request );
}
