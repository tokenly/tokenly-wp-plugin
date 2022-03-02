<?php

namespace Tokenly\Wp\Interfaces\Repositories;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

interface OauthUserRepositoryInterface extends RepositoryInterface {
	public function show( array $params = array() );
}
