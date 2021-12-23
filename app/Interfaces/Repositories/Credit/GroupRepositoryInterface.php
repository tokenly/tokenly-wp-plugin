<?php

namespace Tokenly\Wp\Interfaces\Repositories\Credit;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

interface GroupRepositoryInterface {
	public function index();
	public function show( array $params = array() );
	public function store( array $params = array() );
	public function update( GroupInterface $credit_group, array $params = array() );
}
