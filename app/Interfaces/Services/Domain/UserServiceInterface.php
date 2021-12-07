<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

interface UserServiceInterface extends DomainServiceInterface {
	public function store( OauthUserInterface $oauth_user );
	public function add_view_inventory_user_action( array $actions, \WP_User $user );
}
