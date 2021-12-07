<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface PromiseMetaServiceInterface extends DomainServiceInterface {
	public function store( array $params );
}
