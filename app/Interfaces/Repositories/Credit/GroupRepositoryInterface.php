<?php

namespace Tokenly\Wp\Interfaces\Repositories\Credit;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

interface GroupRepositoryInterface extends RepositoryInterface {
	public function index();
	public function show( array $params = array() );
	public function store( array $params = array() );
	public function update( GroupInterface $group, array $params = array() );
}
