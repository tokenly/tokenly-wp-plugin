<?php

namespace Tokenly\Wp\Interfaces\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Models\PromiseInterface;

interface PromiseControllerInterface {
	public function show( PromiseInterface $promise );
	public function store();
	public function edit();
}
