<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface UserControllerInterface {
	public function index( $request );
	public function show( $request );
}
