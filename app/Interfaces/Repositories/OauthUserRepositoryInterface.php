<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface OauthUserRepositoryInterface {
	public function show( int $user_id );
}
