<?php

namespace Tokenly\Wp\Interfaces\Services\Domain\Credit;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface TransactionServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
}
