<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

interface AddressRepositoryInterface extends RepositoryInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
}
