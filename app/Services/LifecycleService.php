<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Handles version changes
 */
class LifecycleService implements LifecycleServiceInterface {
	public $version;
	protected $option_repository;
	protected $root_filepath;

	public function __construct(
		string $version,
		string $root_filepath,
		OptionRepositoryInterface $option_repository
	) {
		$this->version = $version;
		$this->root_filepath = $root_filepath;
		$this->option_repository = $option_repository;
	}

	public function register() {
		register_activation_hook( $this->root_filepath, array( self::class, 'on_activation' ) );
		register_uninstall_hook( $this->root_filepath, array( self::class, 'on_uninstall' ) );
	}

	/**
	 * Plugin activation callback
	 * @return void
	 */
	public static function on_activation() {
		$this->refresh();
	}

	/**
	 * Plugin deactivation callback
	 * @return void
	 */
	public static function on_uninstall() {
		$this->refresh();
	}

	protected function refresh() {
		flush_rewrite_rules();
	}

	/**
	 * Checks if the app version matches the previously stored one
	 * in the database
	 */
	protected function check_version() {
		$persisted_version = $this->option_repository->show( 'version' );
		if ( $this->version == $persisted_version ) {
			return true;
		}
		$this->refresh();
		$this->option_repository->update( array(
			'version' => $this->version,
		) );
	}
}
