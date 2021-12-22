<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface TokenMetaServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
}
