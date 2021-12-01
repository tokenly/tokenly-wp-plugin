<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;

class GuestUser extends Model implements UserInterface, GuestUserInterface, CurrentUserInterface {
	public $ID = 0;

	public function __construct() {
		//
	}
	
	public function is_guest() {
		return true;
	}
	
	public function can_connect() {
		return false;
	}

	public function get_addresses( array $params = array() ) {
		return array();
	}
	public function get_balances( array $params = array() ) {
		return array();
	}
}
