<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;

/**
 * Manages resources
 */
class ResourceService implements ResourceServiceInterface {
	protected $root_url;
	protected $build_url;
	protected $namespace;

	public function __construct(
		string $root_url,
		string $namespace
	) {
		$this->root_url = $root_url;
		$this->build_url = $this->root_url . '/build';
		$this->namespace = $namespace;
	}

	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
	}

	/**
	 * Embeds scripts and styles on frontend routes
	 * @wp-hook wp_enqueue_scripts
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		$label = "{$this->namespace}-frontend";
		wp_register_script( $label, "{$this->build_url}/Frontend.js", array( 'wp-api' ), null, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Frontend.css" );
		wp_enqueue_style( $label );
	}

	/**
	 * Embeds scripts and styles on admin routes
	 * @wp-hook login_enqueue_scripts
	 * @wp-hook admin_enqueue_scripts
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		$label = "{$this->namespace}-admin";
		wp_register_script( $label, "{$this->build_url}/Admin.js", array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), null, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Admin.css", array( 'wp-components' ) );
		wp_enqueue_style( $label );
	}
}
