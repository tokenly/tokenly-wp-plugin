<?php

namespace Tokenly\Wp\Interfaces\Repositories\General;

interface TermMetaRepositoryInterface {
	public function index( $term_id, $keys );
	public function show( $term_id, $key );
	public function update( $term_id, $payload );
}
