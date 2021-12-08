<?php

namespace Tokenly\Wp\Interfaces\Repositories;

use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;

interface CreditGroupRepositoryInterface {
	public function index();
	public function show( array $params = array() );
	public function store( array $params = array() );
	public function update( CreditGroupInterface $credit_group, array $params = array() );
}
