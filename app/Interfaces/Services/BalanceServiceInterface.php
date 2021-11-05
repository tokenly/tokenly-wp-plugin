<?php

namespace Tokenly\Wp\Interfaces\Services;

interface BalanceServiceInterface {
	public function apply_whitelist( $balances );
	public function embed_token_meta( $balances );
}
