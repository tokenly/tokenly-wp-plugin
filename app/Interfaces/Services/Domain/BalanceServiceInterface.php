<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface BalanceServiceInterface {
	public function index( string $oauth_token, array $params = array() );
}
