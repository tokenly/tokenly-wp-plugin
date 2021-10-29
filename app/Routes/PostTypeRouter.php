<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\Controllers\Web\TokenMetaController;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;

class PostTypeRouter {
	public $routes;

	public function __construct(
		TokenMetaPostType $token_meta_post_type,
		TokenMetaController $token_meta_controller,
		TokenMetaRepository $token_meta_repository
	) {
		$this->post_types = array(
			'token-meta' => array(
				'post_type'  => $token_meta_post_type,
				'controller' => $token_meta_controller,
				'repository' => $token_meta_repository,
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
				'save_callback' => array( $this->post_types['token-meta']['repository'], 'update' ),
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
			add_action( 'save_post', function( $post_id, $post, $update ) {
				
			}, 10,3 );
		}
	}
}
