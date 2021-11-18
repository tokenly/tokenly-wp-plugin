<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface SourceControllerInterface {
	public function index( $request );
	public function store( $request );
	public function update( $request );
	public function destroy( $request );
}
