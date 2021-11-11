<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface BalanceRepositoryInterface {
	public function index( $user_id, $use_whitelist, $add_meta );
}
