<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface OauthUserRepositoryInterface {
	public function show( array $params = array() );
}
