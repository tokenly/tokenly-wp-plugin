<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface AuthControllerInterface {
	public function show();
	public function store();
	public function destroy();
	public function callback();
}
