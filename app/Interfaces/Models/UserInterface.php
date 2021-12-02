<?php

namespace Tokenly\Wp\Interfaces\Models;

interface UserInterface {
	public function can_connect();
	public function connect( OauthUserInterface $oauth_user, string $oauth_token );
	public function disconnect();
}
