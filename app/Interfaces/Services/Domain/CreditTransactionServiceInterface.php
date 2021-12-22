<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface CreditTransactionServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
}
