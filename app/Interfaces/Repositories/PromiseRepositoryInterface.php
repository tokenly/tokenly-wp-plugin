<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface PromiseRepositoryInterface {
	public function index( array $params = array() );
	public function show( int $promise_id, array $params = array() );
	public function update( int $promise_id, array $params = array() );
	public function store( array $params = array() );
	public function destroy( int $promise_id );
}
