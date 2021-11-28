<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface PromiseRepositoryInterface {
	public function index();
	public function show( int $promise_id );
	public function update( int $promise_id, array $params = array() );
	public function store( array $params = array() );
	public function destroy( int $promise_id );
}
