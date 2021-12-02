<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface SourceServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function store( array $params );
}
