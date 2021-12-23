<?php

namespace Tokenly\Wp\Interfaces\Repositories\Credit;

interface TransactionRepositoryInterface {
	public function index( array $params = array() );
	public function store( array $params = array() );
}
