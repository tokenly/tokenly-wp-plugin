<?php

namespace Tokenly\Wp\Interfaces\Collections;

interface BalanceCollectionInterface {
	public function apply_whitelist( $balances );
	public function embed_token_meta( $balances );
}
