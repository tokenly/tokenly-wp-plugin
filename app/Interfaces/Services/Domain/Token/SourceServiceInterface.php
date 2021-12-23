<?php

namespace Tokenly\Wp\Interfaces\Services\Domain\Token;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface SourceServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function store( array $params );
}
