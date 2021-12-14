<?php

namespace Tokenly\Wp\Routes;

use Tokenly\Wp\Routes\Router;
use Tokenly\Wp\Interfaces\Routes\TaxonomyRouterInterface;
use Twig\Environment;

/**
 * Manages routing for the post type views
 */
class TaxonomyRouter extends Router implements TaxonomyRouterInterface {
	protected $namespace;
	protected $tca_settings;
	protected $twig;
	protected $default_template = 'Dynamic.twig';
	
	public function __construct(
		string $namespace,
		TcaSettingsInterface $tca_settings,
		Environment $twig
	) {
		$this->namespace = $namespace;
		$this->tca_settings = $tca_settings;
		$this->twig = $twig;
	}

	public function register() {

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
		foreach ( $tca_taxonomies as $key => $taxonomy ) {
			$routes[ $key ] = array(
				'name'          => $key,
				'edit_callback' => array( $this->post_types['post']['controller'], 'edit' ),
			);
		}
		return $routes;
	}
	
	public function register_routes() {
		
	}
}
