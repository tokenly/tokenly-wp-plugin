<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;

interface PromiseRepositoryInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function store( array $params = array() );
	public function update( PromiseInterface $promise, array $params = array() );
	public function destroy( PromiseInterface $promise );
}
