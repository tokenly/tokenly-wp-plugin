<?php

namespace Tokenly\Wp\Interfaces\Repositories;

use Tokenly\Wp\Interfaces\Models\TermInterface;

interface TermRepositoryInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function update( TermInterface $term, array $params = array() );
}
