<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;

interface PromiseRepositoryInterface {
	public function index();
	public function show( int $promise_id );
	public function store( array $params = array() );
	public function update( PromiseInterface $promise, array $params = array() );
	public function destroy( PromiseInterface $promise );
}
