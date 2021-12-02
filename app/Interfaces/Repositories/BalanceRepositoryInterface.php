<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface BalanceRepositoryInterface {
	public function index( string $oauth_token, array $params = array() );
}
