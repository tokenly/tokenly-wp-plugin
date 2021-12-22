<?php

namespace Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Models\PromiseInterface;

interface PromiseControllerInterface {
	public function show();
	public function store();
	public function edit();
}
