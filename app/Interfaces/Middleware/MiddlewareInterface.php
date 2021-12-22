<?php

namespace Tokenly\Wp\Interfaces\Middleware;

interface MiddlewareInterface {
	public function register();
	public function run();
}
