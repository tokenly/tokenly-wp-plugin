<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface TokenMetaServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function update( int $post_id, array $params = array() );
	public function get_token_meta( int $id );
}
