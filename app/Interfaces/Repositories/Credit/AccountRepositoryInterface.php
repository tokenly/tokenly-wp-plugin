<?php

namespace Tokenly\Wp\Interfaces\Repositories\Credit;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

interface AccountRepositoryInterface extends RepositoryInterface {
	public function index( array $parameters = array() );
	public function show( array $parameters = array() );
	public function show_history( array $params = array() );
	public function store( array $params = array() );
}
