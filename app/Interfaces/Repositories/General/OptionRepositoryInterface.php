<?php

namespace Tokenly\Wp\Interfaces\Services\General;

interface OptionRepositoryInterface {
	public function index( $keys );
	public function show( $key );
	public function update( $payload );
}
