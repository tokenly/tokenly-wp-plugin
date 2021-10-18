<?php

namespace Tokenly\Wp\Controllers\Web;

class UserController {
	public function show() {
		include( TOKENLY_PLUGIN_DIR . 'resources/views/user.php' );
	}
}
