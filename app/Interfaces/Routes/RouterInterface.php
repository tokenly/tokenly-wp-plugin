<?php

namespace Tokenly\Wp\Interfaces\Routes;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

interface RouterInterface extends ServiceInterface {
	public function register();
	public function render_route( callable $render_function, array $arguments = array() );
	public function register_routes();
	public function register_route( string $key, array $route );
}
