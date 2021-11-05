<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface AdminRouterInterface {
	public function register();
	public function add_redirects();
	public function can_view_inventory();
	public function get_routes();
	public function prepare_routes( $routes );
	public function get_subroute_slug( $route, $subroute );
	public function register_routes();
}
