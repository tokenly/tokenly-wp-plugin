<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;

/**
 * Manages resources
 */
class ResourceService extends Service implements ResourceServiceInterface {
	protected $root_url;
	protected $root_dir;
	protected $build_url;
	protected $namespace;

	public function __construct(
		string $root_url,
		string $root_dir,
		string $namespace
	) {
		$this->root_url = $root_url;
		$this->root_dir = $root_dir;
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
		$version = $this->get_version_for_build( 'Frontend' );
		$label = "{$this->namespace}-frontend";
		wp_register_script( $label, "{$this->build_url}/Frontend.js", array( 'wp-api' ), $version, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Frontend.css", $version );
		wp_enqueue_style( $label );
	}

	/**
	 * Embeds scripts and styles on admin routes
	 * @wp-hook login_enqueue_scripts
	 * @wp-hook admin_enqueue_scripts
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		$version = $this->get_version_for_build( 'Admin' );
		$label = "{$this->namespace}-admin";
		wp_register_script( $label, "{$this->build_url}/Admin.js", array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), $version, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Admin.css", array( 'wp-components' ), $version );
		wp_enqueue_style( $label );
	}

	/**
	 * Extracts the version for the specified build from the build asset file
	 * @param string $build_name Name of the build
	 * @return string
	 */
	protected function get_version_for_build( string $build_name ) {
		$meta = include( "{$this->root_dir}/build/{$build_name}.asset.php" );
		$version = 1;
		if ( $meta && isset( $meta['version'] ) ) {
			$version = $meta['version'];
		}
		return $version;
	}
}
