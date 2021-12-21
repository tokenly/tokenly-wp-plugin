<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\User;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class GuestUser extends User implements GuestUserInterface, CurrentUserInterface {
	public $ID = 0;
	
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

	public function has_cap() {
		return false;
	}
}
