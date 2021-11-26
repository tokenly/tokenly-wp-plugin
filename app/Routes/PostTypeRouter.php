<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\PostTypes\PromiseMetaPostType;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Routes\Router;
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
					add_meta_box(
						'tokenpass_data',
						__( 'Tokenpass', 'textdomain' ),
						$callable,
						$name,
						'advanced',
						'high'
					);
				} );
			}
		}
	}

	public function on_template_redirect() {
		$post_id = get_the_ID();
		$can_access = $this->post_service->can_access_post( $post_id, $current_user->ID );
		if ( $can_access === false ) {
			wp_redirect( get_home_url() );
			exit();
		}
	}
}
