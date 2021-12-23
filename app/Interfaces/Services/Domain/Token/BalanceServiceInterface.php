<?php

namespace Tokenly\Wp\Interfaces\Services\Domain\Token;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface BalanceServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
}
