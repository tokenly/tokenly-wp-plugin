<?php

namespace Tokenly\Wp\Interfaces\Repositories;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

interface UserRepositoryInterface extends RepositoryInterface {
	public function index( array $params );
	public function show( array $params );
	public function store( OauthUserInterface $oauth_user );
}
