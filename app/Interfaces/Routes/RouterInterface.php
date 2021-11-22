<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface RouterInterface {
	public function register();
	public function render_route( callable $render_function );
	public function register_routes();
	public function register_route( string $key, array $route );
}
