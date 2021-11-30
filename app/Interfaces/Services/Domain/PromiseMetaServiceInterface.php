<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface PromiseMetaServiceInterface {
	public function get_promise_meta( int $id );
	public function index( array $params = array() );
	public function show( $params = array() );
	public function store( array $params );
	public function update( int $post_id, array $params = array() );
	public function destroy( int $post_id );
}
