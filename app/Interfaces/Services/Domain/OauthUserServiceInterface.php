<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface OauthUserServiceInterface extends DomainServiceInterface {
	public function show( array $params = array() );
}
