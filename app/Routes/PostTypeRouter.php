<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\PostTypes\TokenMetaPostType;
use Tokenly\Wp\PostTypes\PromiseMetaPostType;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface as TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PostCollectionFactoryInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Middleware\Tca\MenuItemFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostResultsFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostGuardMiddlewareInterface;

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
	protected $post_service;
	protected $twig;
	protected $default_template = 'Index.twig';
	
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
		Environment $twig,
		string $namespace,
		MenuItemFilterMiddlewareInterface $tca_menu_item_filter_middleware,
		PostResultsFilterMiddlewareInterface $tca_post_results_filter_middleware,
		PostGuardMiddlewareInterface $tca_post_guard_middleware
	) {
		$this->middleware = array(
			'tca_menu_item_filter'    => $tca_menu_item_filter_middleware,
			'tca_post_results_filter' => $tca_post_results_filter_middleware,
			'tca_post_guard'          => $tca_post_guard_middleware,
		);
		$this->integration = $integration;
		$this->current_user = $current_user;
		$this->tca_settings = $tca_settings;
		$this->namespace = $namespace;
		$this->post_service = $post_service;
		$this->twig = $twig;
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
		parent::register();
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
		if ( !isset( $_POST[ "{$this->namespace}_data" ] ) ) {
			return;
		}
		$params = $_POST[ "{$this->namespace}_data" ];
		$params = wp_unslash( $params );
		$params = json_decode( $params, true );
		if ( isset( $this->routes[ $post_type_key ] ) && isset( $this->routes[ $post_type_key ]['show_callback'] ) ) {
			$post = call_user_func(
				$this->routes[ $post_type_key ]['show_callback'],
				array(
					'id' => $post_id,
				)
			);
			if ( !$post ) {
				return;
			}
			$post->update( $params );
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
				'show_callback' => array( $this->post_types['token_meta']['service'], 'show' ),
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
				'show_callback' => array( $this->post_types['post']['service'], 'show' ),
			);
		}
		return $routes;
	}
	
	public function register_routes() {
		if ( !$this->can_register() ) {
			return;
		}
		foreach ( $this->routes as $key => $route ) {
			$this->register_post_type( $route );
			$route = $this->register_edit_callback( $route );
		}
	}
	
	protected function register_post_type( array $route ) {
		if ( !isset( $route['post_type'] ) ) {
			return;
		}
		$name = $route['name'];
		$args = $route['post_type']->get_args();
		$slug = $route['slug'];
		$args['rewrite'] = array( 'slug' => $slug );
		register_post_type( $name, $args );
	}
	
	protected function register_edit_callback( array $route ) {
		if ( !isset( $route['edit_callback'] ) ) {
			return $route;
		}
		$name = $route['name'];
		$callable = $route['edit_callback'];
		$callable = function() use ( $callable, $name ) {
			$this->render_route( $callable );
		};
		$route['edit_callback'] = $callable;
		add_action( 'add_meta_boxes', function() use ( $callable, $name ) {
			$this->render_edit_callback( $callable, $name );
		} );
		return $route;
	}
	
	protected function render_edit_callback( callable $callable, string $name ) {
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
	}
}
