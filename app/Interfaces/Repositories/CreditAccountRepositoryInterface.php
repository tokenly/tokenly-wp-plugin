<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface CreditAccountRepositoryInterface {
	public function index( array $parameters = array() );
	public function show( array $parameters = array() );
}
