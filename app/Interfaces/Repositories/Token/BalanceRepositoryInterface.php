<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

interface BalanceRepositoryInterface extends RepositoryInterface {
	public function index( array $params = array() );
}
