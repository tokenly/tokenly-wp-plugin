<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface ApiRouterInterface {
	public function register();
	public function get_routes();
	public function get_route_urls();
	public function register_routes();
}
