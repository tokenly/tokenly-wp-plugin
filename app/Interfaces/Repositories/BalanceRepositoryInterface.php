<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface BalanceRepositoryInterface {
	public function index( interger $user_id, array $params );
}
