<?php

namespace Tokenly\Wp\Interfaces\Services;

interface SourceRepositoryInterface {
	public function show( $address );
	public function index();
	public function store( $source );
	public function update( $address, $params );
	public function destroy( $address );
}
