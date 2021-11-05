<?php

namespace Tokenly\Wp\Interfaces\Services;

interface PromiseRepositoryInterface {
	public function index();
	public function show( $promise_id );
	public function update( $promise_id, $params );
	public function store( $params );
	public function destroy( $promise_id );
}
