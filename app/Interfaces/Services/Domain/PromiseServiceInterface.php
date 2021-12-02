<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface PromiseServiceInterface {
	public function index( array $params = array() );
	public function show( int $promise_id, array $params = array() );
	public function store( array $params = array() );
}
