<?php

namespace Tokenly\Wp\Interfaces\Services;

interface BalanceRepositoryInterface {
	public function index( $user_id, $whitelist = true, $meta = true );
}
