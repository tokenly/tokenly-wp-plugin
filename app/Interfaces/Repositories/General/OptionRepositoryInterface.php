<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface OptionRepositoryInterface {
	public function index( $keys );
	public function show( $key );
	public function update( $payload );
}
