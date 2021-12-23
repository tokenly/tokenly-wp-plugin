<?php

namespace Tokenly\Wp\Interfaces\Repositories\Token;

use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

interface SourceRepositoryInterface {
	public function show( array $params = array() );
	public function index( array $params = array() );
	public function store( array $params = array() );
	public function update( SourceInterface $source, array $params );
	public function destroy( SourceInterface $source );
}
