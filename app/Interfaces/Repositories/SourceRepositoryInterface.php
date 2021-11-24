<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface SourceRepositoryInterface {
	public function show( array $params = array() );
	public function index( array $params = array() );
	public function store( array $params = array() );
	public function update( $address, $params );
	public function destroy( $address );
}
