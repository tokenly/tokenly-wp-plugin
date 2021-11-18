<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class GuestUser implements CurrentUserInterface {
	public function __construct() {
		//
	}
	
	public function is_guest() {
		return true;
	}
}
