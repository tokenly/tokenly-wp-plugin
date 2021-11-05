<?php

namespace Tokenly\Wp\Interfaces\Services\General;

interface MetaRepositoryInterface {
	public function index( $post_id, $keys );
	public function show( $post_id, $key );
	public function update( $post_id, $payload );
}
