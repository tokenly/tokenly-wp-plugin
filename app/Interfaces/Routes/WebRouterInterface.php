<?php

namespace Tokenly\Wp\Interfaces\Routes;

interface WebRouterInterface {
	public function register();
	public function get_routes();
	public function merge_rewrite_rules( $wp_rewrite );
	public function merge_query_vars( $query_vars );
	public function find_template( $template );
	public function register_routes();
}
