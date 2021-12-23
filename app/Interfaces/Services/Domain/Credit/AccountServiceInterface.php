<?php

namespace Tokenly\Wp\Interfaces\Services\Domain\Credit;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface AccountServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function store( array $params = array() );
}
