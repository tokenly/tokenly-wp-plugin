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
			add_action( "{$key}_add_form_fields", $route['edit_callback'] );
			add_action( "{$key}_edit_form_fields", $route['edit_callback'] );
		}
	}
	
}
