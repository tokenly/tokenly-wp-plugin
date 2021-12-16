<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\TaxonomyRouterInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TermControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;
use Twig\Environment;

/**
 * Manages routing for the post type views
 */
class TaxonomyRouter extends Router implements TaxonomyRouterInterface {
	protected $namespace;
	protected $tca_settings;
	protected $term_controller;
	protected $term_service;
	protected $twig;
	protected $default_template = 'Dynamic.twig';
	
	public function __construct(
		string $namespace,
		TcaSettingsInterface $tca_settings,
		TermControllerInterface $term_controller,
		TermServiceInterface $term_service,
		Environment $twig
	) {
		$this->namespace = $namespace;
		$this->tca_settings = $tca_settings;
		$this->term_controller = $term_controller;
		$this->term_service = $term_service;
		$this->twig = $twig;
	}

	public function register() {
		parent::register();
		add_action( 'saved_term', array( $this, 'on_saved_term' ), 10, 4 );
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
				'edit_callback' => array( $this->term_controller, 'edit' ),
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
				//add_action( "{$key}_add_form", $route['edit_callback'] );
				add_action( "{$key}_edit_form", $route['edit_callback'] );
			}
		}
	}

	public function on_saved_term( int $term_id, int $tt_id, string $taxonomy, bool $update ) {
		if ( !array_key_exists( $taxonomy, $this->routes ) ) {
			return;
		}
		if ( !isset( $_POST[ "{$this->namespace}_data" ] ) ) {
			return;
		}
		$term = $this->term_service->show( array(
			'include'  => $term_id,
			'taxonomy' => $taxonomy,
		) );
		if ( !$term ) {
			return;
		}
		$params = $_POST[ "{$this->namespace}_data" ];
		$params = wp_unslash( $params );
		$params = json_decode( $params, true );
		$term->update( $params );
		return $term;
	}
}
