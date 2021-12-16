<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class GuestUser extends Model implements UserInterface, GuestUserInterface, CurrentUserInterface {
	public $ID = 0;

	public function __construct() {
		//
	}
	
	public function is_guest() {
		return true;
	}

	public function connect( OauthUserInterface $oauth_user, string $oauth_token ) {
		return false;
	}
	public function disconnect() {
		return false;
	}
	
	public function can_connect() {
		return false;
	}

	public function check_token_access() {
		return false;
	}

	public function has_cap() {
		return false;
	}
}
