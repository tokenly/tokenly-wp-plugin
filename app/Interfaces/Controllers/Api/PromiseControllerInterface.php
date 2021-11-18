<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface PromiseControllerInterface {
	public function index( $request );
	public function store( $request );
	public function update( $request );
	public function destroy( $request );
}
