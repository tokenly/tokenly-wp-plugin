<?php

namespace Tokenly\Wp\Interfaces\Controllers\Web;

interface AuthControllerInterface {
	public function store();
	public function destroy();
	public function callback();
}
