<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\PostTypes\PromiseMetaPostType;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;

/**
 * Manages routing for the post type views
 */
class PostTypeRouter extends Router implements PostTypeRouterInterface {
	protected $routes;
	protected $namespace;
	protected $integration;
	protected $post_types;
	protected $current_user;
	protected $tca_settings;
	protected $tca_service;
	
	public function __construct(
		TokenMetaPostType $token_meta_post_type,
		PromiseMetaPostType $promise_meta_post_type,
		TokenMetaControllerInterface $token_meta_controller,
		TokenMetaServiceInterface $token_meta_service,
		PostControllerInterface $post_controller,
		PostServiceInterface $post_service,
		IntegrationInterface $integration,
		CurrentUserInterface $current_user,
		TcaSettingsInterface $tca_settings,
		TcaServiceInterface $tca_service,
		string $namespace
	) {
		$this->integration = $integration;
		$this->current_user = $current_user;
		$this->tca_settings = $tca_settings;
		$this->tca_service = $tca_service;
		$this->namespace = $namespace;
		$this->post_service = $post_service;
		$this->post_types = array(
			'token_meta' => array(
				'post_type'  => $token_meta_post_type,
				'controller' => $token_meta_controller,
				'service'    => $token_meta_service,
			),
			'promise_meta'    => array(
				'post_type'  => $promise_meta_post_type,
			),
			'post'       => array(
				'controller' => $post_controller,
				'service'    => $post_service,
			),
		);
	}

	public function register() {
		$this->routes = $this->get_routes();
		$this->register_routes();
		add_action( 'template_redirect', array( $this, 'on_template_redirect' ) );
		add_action( 'save_post', array( $this, 'on_post_save' ), 10, 3 );
		if (
			isset( $this->tca_settings->filter_menu_items ) &&
			$this->tca_settings->filter_menu_items == true
		) {
			add_filter( 'wp_get_nav_menu_items', array( $this, 'tca_on_get_nav_menu_items' ), 10, 3 );
		}
		if (
			isset( $this->tca_settings->filter_post_results ) &&
			$this->tca_settings->filter_post_results == true
		) {
			add_filter( 'posts_results', array( $this, 'tca_on_posts_results' ), 10, 3 );
		}
	}

	/**
	 * Passes the data from the post edit page to
	 * the post type service
	 * @param int $post_id Post index
	 * @param \WP_Post $post Post object
	 * @param bool $update Is existing post
	 * @return void
	 */
	public function on_post_save( int $post_id, \WP_Post $post, bool $update ) {
		$post_type = $post->post_type;
		$post_type_key = str_replace( "{$this->namespace}_", '', $post_type );
		$params = $_POST["{$this->namespace}_data"] ?? array();
		if ( $params ) {
			$params = wp_unslash( $params );
			$params = json_decode( $params, true );
		}
		if ( isset( $this->routes[ $post_type_key ] ) && isset( $this->routes[ $post_type_key ]['save_callback'] ) ) {
			call_user_func( $this->routes[ $post_type_key ]['save_callback'], $post_id, $params );
		}
	}
	
	protected function can_register() {
		if ( $this->integration->can_connect() && $this->current_user->can_connect() ) {
			return true;
		} else {
			return false;
		}
	}

	protected function get_routes() {
		$routes = array(
			'token_meta' => array(
				'name'          => 'token_meta',
				'slug'          => 'token-meta',
				'post_type'     => $this->post_types['token_meta']['post_type'],
				'edit_callback' => array( $this->post_types['token_meta']['controller'], 'edit' ),
				'save_callback' => array( $this->post_types['token_meta']['service'], 'update' ),
			),
			'promise_meta'   => array(
				'name'          => 'promise_meta',
				'slug'          => 'promise-meta',
				'post_type'     => $this->post_types['promise_meta']['post_type'],
			)
		);
		$routes = $this->process_routes( $routes );
		return $routes;
	}

	protected function process_routes( array $routes ) {
		$routes = $this->add_tca_routes( $routes );
		return $routes;
	}

	protected function add_tca_routes( array $routes ) {
		if ( !isset( $this->tca_settings->post_types ) ) {
			return $routes;
		}
		$tca_post_types = $this->tca_settings->post_types;
		foreach ( $routes as $key => &$route ) {
			$route['name'] = "{$this->namespace}_{$route['name']}";
			$route['slug'] = "{$this->namespace}-{$route['slug']}";
			$name = $route['name'];
			$use_tca = false;
			if ( isset( $tca_post_types[ $name ] ) ) {
				$use_tca = $tca_post_types[ $name ] ?? false;
				unset( $tca_post_types[ $name ] );
			}
			$route['use_tca'] = $use_tca; 
		}
		foreach ( $tca_post_types as $key => $post_type ) {
			$routes[ $key ] = array(
				'name'          => $key,
				'edit_callback' => array( $this->post_types['post']['controller'], 'edit' ),
				'save_callback' => array( $this->post_types['post']['service'], 'update' ),
			);
		}
		return $routes;
	}
	
	public function register_routes() {
		if ( !$this->can_register() ) {
			return;
		}
		foreach ( $this->routes as $key => $route ) {
			$name = $route['name'];
			if ( isset( $route['post_type'] ) ) {
				$args = $route['post_type']->get_args();
				$slug = $route['slug'];
				$args['rewrite'] = array( 'slug' => $slug );
				register_post_type( $name, $args );
			}
			if ( isset( $route['edit_callback'] ) ) {
				$callable = $route['edit_callback'];
				$callable = function() use ( $callable, $name ) {
					$this->render_route( $callable );
				};
				$route['edit_callback'] = $callable;
				add_action( 'add_meta_boxes', function() use ( $callable, $name ) {
					$meta_box_name = "{$this->namespace}_data";
					$meta_box_title = ucfirst( $this->namespace );
					add_meta_box(
						$meta_box_name,
						__( $meta_box_title, 'textdomain' ),
						$callable,
						$name,
						'advanced',
						'high'
					);
				} );
			}
		}
	}

	/**
	 * Prevents access to post if the TCA check was not passed
	 * @return void
	 */
	public function on_template_redirect() {
		$is_virtual = boolval( get_query_var( "{$this->namespace}_virtual" ) ) ?? false;
		if ( $is_virtual === true ) {
			return;
		}
		$post_id = get_the_ID();
		$can_access = $this->post_service->can_access_post( $post_id, $this->current_user );
		if ( $can_access === false ) {
			if ( is_admin() === true ) {
				wp_die( 'Access denied by TCA.' );
			} else {
				wp_redirect( "/{$this->namespace}/access-denied" );
				exit;
			}
		}
	}

	/**
	 * Filters the reuslts of navigation menu item queries by checking
	 * if the current user can access the post associated with it
	 * @param array $item Navigation items
	 * @param object $menu Navigation menu
	 * @param array $args Additional arguments
	 * @return array
	 */
	public function tca_on_get_nav_menu_items( array $items, object $menu, array $args ) {
		foreach ( $items as $key => $item ) {
			$post_id = $item->object_id;
			$can_access = $this->post_service->can_access_post( $post_id, $this->current_user );
			if ( $can_access === false ) {
				unset( $items[ $key ] );
			}
		}
		return $items;
	}

	/**
	 * Filters the results of post queries by checking
	 * if the current user can access them
	 * @param array $posts
	 * @return array
	 */
	public function tca_on_posts_results( array $posts, $query ) {
		$current_post_id = 0;
		$is_singular = $query->is_singular;
		if ( $is_singular == true && isset( $query->posts[0] )) {
			$post = $query->posts[0];
			$current_post_id = $post->ID;
		}
		foreach ( $posts as $key => $post ) {
			$post_id = $post->ID;
			$can_access = $this->post_service->can_access_post( $post_id, $this->current_user );
			if ( $can_access === false && $current_post_id != $post_id ) {			
				unset( $posts[ $key ] );
			}
		}
		return $posts;
	}
}
