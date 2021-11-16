<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\PostTypes\PromiseMetaPostType;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;

/**
 * Manages routing for the post type views
 */
class PostTypeRouter implements PostTypeRouterInterface {
	protected $routes;
	protected $namespace;

	public function __construct(
		TokenMetaPostType $token_meta_post_type,
		PromiseMetaPostType $promise_meta_post_type,
		TokenMetaControllerInterface $token_meta_controller,
		TokenMetaRepositoryInterface $token_meta_repository,
		$namespace
	) {
		$this->namespace = $namespace;
		$this->post_types = array(
			'token_meta' => array(
				'post_type'  => $token_meta_post_type,
				'controller' => $token_meta_controller,
				'repository' => $token_meta_repository,
			),
			'promise_meta'    => array(
				'post_type'  => $promise_meta_post_type,
			)
		);
	}

	public function register() {
		$this->routes = $this->get_routes();
		$this->register_routes();
	}

	/**
	 * Passes the data from the post edit page to
	 * the post type repository
	 * @param int $post_id Post index
	 * @param \WP_Post $post Post object
	 * @param bool $update Is existing post
	 * @return void
	 */
	public function on_post_save( int $post_id, \WP_Post $post, bool $update ) {
		$post_type = $post->post_type;
		$post_type_key = str_replace( "{$this->namespace}_", '', $post_type );
		$params = $_POST['tokenly_data'] ?? null;
		if ( $params ) {
			$params = wp_unslash( $params );
			$params = json_decode( $params, true );
		}
		if ( isset( $this->routes[ $post_type_key ] ) && isset( $this->routes[ $post_type_key ]['save_callback'] ) ) {
			call_user_func( $this->routes[ $post_type_key ]['save_callback'], $post_id, $params );
		}
	}

	protected function get_routes() {
		$routes = array(
			'token_meta' => array(
				'name'          => 'token_meta',
				'slug'          => 'token-meta',
				'post_type'     => $this->post_types['token_meta']['post_type'],
				'edit_callback' => array( $this->post_types['token_meta']['controller'], 'edit' ),
				'save_callback' => array( $this->post_types['token_meta']['repository'], 'update' ),
			),
			'promise_meta'   => array(
				'name'          => 'promise_meta',
				'slug'          => 'promise-meta',
				'post_type'     => $this->post_types['promise_meta']['post_type'],
			)
		);
		return $routes;
	}
	
	protected function register_routes() {
		foreach ( $this->routes as $route ) {
			$name = $route['name'];
			$name = "{$this->namespace}_{$name}";
			$slug = $route['slug'];
			$slug = "{$this->namespace}-{$slug}";
			$args = $route['post_type']->get_args();
			$args['rewrite'] = array( 'slug' => $slug );
			register_post_type( $name, $args );
			if ( isset( $route['edit_callbakc'] ) ) {
				add_action( 'edit_form_advanced', $route['edit_callback'] );
			}
		}
		add_action( 'save_post', array( $this, 'on_post_save' ), 10, 3 );
	}
}
