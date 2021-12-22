<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface CreditTransactionRepositoryInterface {
	public function index( array $params = array() );
	public function store( array $params = array() );
}
