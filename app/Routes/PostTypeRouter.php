<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\Controllers\Web\TokenMetaController;

class PostTypeRouter {
	public $routes;

	public function __construct(
		TokenMetaPostType $token_meta_post_type,
		TokenMetaController $token_meta_controller
	) {
		$this->post_types = array(
			'token-meta' => array(
				'post_type'  => $token_meta_post_type,
				'controller' => $token_meta_controller,
			),
		);
	}

	public function register() {
		$this->routes = $this->get_routes();
		$this->register_routes();
	}

	public function get_routes() {
		$routes = array(
			'token-meta' => array(
				'name'          => 'token-meta',
				'post_type'     => $this->post_types['token-meta']['post_type'],
				'edit_callback' => array( $this->post_types['token-meta']['controller'], 'edit' ),
			),
		);
		return $routes;
	}
	
	public function register_routes() {
		foreach ( $this->routes as $route ) {
			$name = $route['name'];
			$args = $route['post_type']->get_args();
			register_post_type( $name, $args );
			add_action( 'edit_form_advanced', $route['edit_callback'] );
		}
	}
}
