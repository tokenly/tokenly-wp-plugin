<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

interface UserInterface extends ModelInterface {
	public function can_connect();
	public function connect( OauthUserInterface $oauth_user, string $oauth_token );
	public function disconnect();
}
