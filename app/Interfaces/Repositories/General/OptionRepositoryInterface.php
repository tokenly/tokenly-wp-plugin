<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface OptionRepositoryInterface {
	public function index( array $keys );
	public function show( string $key );
	public function update( array $payload );
}
