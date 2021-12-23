<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

interface AddressRepositoryInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
}
