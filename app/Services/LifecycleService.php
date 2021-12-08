<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

/**
 * Handles version changes
 */
class LifecycleService extends Service implements LifecycleServiceInterface {
	public $version;
	protected $option_repository;
	protected $root_filepath;
	protected $root_dir;

	public function __construct(
		OptionRepositoryInterface $option_repository,
		string $root_filepath,
		string $root_dir
	) {
		$this->root_filepath = $root_filepath;
		$this->root_dir = $root_dir;
		$this->option_repository = $option_repository;
		$this->version = $this->get_current_git_commit();
	}

	public function register() {
		register_activation_hook( $this->root_filepath, array( self::class, 'on_activation' ) );
		register_uninstall_hook( $this->root_filepath, array( self::class, 'on_uninstall' ) );
		$this->check_version();
	}

	/**
	 * Plugin activation callback
	 * @return void
	 */
	public static function on_activation() {
		$this->check_version();
	}

	/**
	 * Plugin deactivation callback
	 * @return void
	 */
	public static function on_uninstall() {
		$this->check_version();
	}

	protected function refresh() {
		flush_rewrite_rules();
	}

	protected function get_current_git_commit( string $branch = 'dev' ) {
		if ( $hash = file_get_contents( "{$this->root_dir}/.git/refs/heads/{$branch}" ) ) {
			return $hash;
		} else {
			return false;
		}
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
