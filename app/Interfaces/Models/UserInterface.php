<?php

namespace Tokenly\Wp\Interfaces\Models;

interface UserInterface {
	public function get_addresses( array $params = array() );
	public function get_balances( array $params = array() );
}
