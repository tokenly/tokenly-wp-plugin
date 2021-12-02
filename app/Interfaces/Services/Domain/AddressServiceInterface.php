<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface AddressServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
}
