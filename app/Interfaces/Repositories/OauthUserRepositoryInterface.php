<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface OauthUserRepositoryInterface {
	public function show( string $oauth_token );
}
