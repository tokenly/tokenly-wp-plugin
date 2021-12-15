<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\TaxonomyRouterInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TaxonomyControllerInterface;
use Twig\Environment;

/**
 * Manages routing for the post type views
 */
class TaxonomyRouter extends Router implements TaxonomyRouterInterface {
	protected $namespace;
	protected $tca_settings;
	protected $taxonomy_controller;
	protected $twig;
	protected $default_template = 'Dynamic.twig';
	
	public function __construct(
		string $namespace,
		TcaSettingsInterface $tca_settings,
		TaxonomyControllerInterface $taxonomy_controller,
		Environment $twig
	) {
		$this->namespace = $namespace;
		$this->tca_settings = $tca_settings;
		$this->taxonomy_controller = $taxonomy_controller;
		$this->twig = $twig;
	}

	protected function get_routes() {
		$routes = array();
		$routes = $this->process_routes( $routes );
		return $routes;
	}

	protected function process_routes( array $routes ) {
		$routes = $this->add_tca_routes( $routes );
		return $routes;
	}

	protected function add_tca_routes( array $routes ) {
		if ( !isset( $this->tca_settings->taxonomies ) ) {
			return $routes;
		}
		$tca_taxonomies = $this->tca_settings->taxonomies;
		foreach ( $tca_taxonomies as $key => $enabled ) {
			if ( $this->tca_settings->is_enabled_for_taxonomy( $key ) == false ) {
				continue;
			}
			$routes[ $key ] = array(
				'name'          => $key,
				'edit_callback' => array( $this->taxonomy_controller, 'edit' ),
			);
		}
		return $routes;
	}

	public function register_routes() {
		foreach ( $this->routes as $key => $route ) {
			if ( isset( $route['edit_callback'] ) ) {
				$callable = $route['edit_callback'];
				$callable = function( \WP_Term $term ) use ( $callable ) {
					$arguments = func_get_args();
					$this->render_route( $callable, $arguments );
				};
				$route['edit_callback'] = $callable;
				add_action( "{$key}_add_form", $route['edit_callback'] );
				add_action( "{$key}_edit_form", $route['edit_callback'] );
			}
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
	public function on_term_save( int $post_id, \WP_Post $post, bool $update ) {
		$post_type = $post->post_type;
		$post_type_key = str_replace( "{$this->namespace}_", '', $post_type );
		$params = $_POST[ "{$this->namespace}_data" ] ?? array();
		if ( $params ) {
			$params = wp_unslash( $params );
			$params = json_decode( $params, true );
		}
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
}
