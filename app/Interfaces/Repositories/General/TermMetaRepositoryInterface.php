<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface TermMetaRepositoryInterface {
	public function index( int $term_id, ...$keys );
	public function show( int $term_id, $key );
	public function update( int $term_id, $payload );
}
