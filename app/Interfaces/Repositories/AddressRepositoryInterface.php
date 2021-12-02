<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface AddressRepositoryInterface {
	public function index( $params = array() );
	public function show( array $params = array() );
}
