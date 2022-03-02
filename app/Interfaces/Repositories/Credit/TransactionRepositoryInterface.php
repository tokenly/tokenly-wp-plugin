<?php

namespace Tokenly\Wp\Interfaces\Repositories\Credit;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

interface TransactionRepositoryInterface extends RepositoryInterface {
	public function index( array $params = array() );
}
