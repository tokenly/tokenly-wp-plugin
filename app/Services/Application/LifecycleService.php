<?php

namespace Tokenly\Wp\Services\Application;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\LifecycleServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Handles version changes
 */
class LifecycleService extends Service implements LifecycleServiceInterface {
	public string $version;
	protected OptionRepositoryInterface $option_repository;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected string $root_filepath;
	protected string $root_dir;
	protected TokenpassAPIInterface $client;

	public function __construct(
		OptionRepositoryInterface $option_repository,
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		string $root_filepath,
		string $root_dir,
		TokenpassAPIInterface $client
	) {
		$this->root_filepath = $root_filepath;
		$this->root_dir = $root_dir;
		$this->option_repository = $option_repository;
		$this->integration_settings_repository = $integration_settings_repository;
		$this->integration_settings = $this->integration_settings_repository->show();
		$this->version = $this->get_current_git_commit();
		$this->client = $client;
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		register_activation_hook( $this->root_filepath, array( self::class, 'on_activation' ) );
		register_uninstall_hook( $this->root_filepath, array( self::class, 'on_uninstall' ) );
		$this->check_version();
		$this->check_connection();
	}

	/**
	 * Plugin activation callback
	 * @return void
	 */
	public static function on_activation(): void {
		$this->check_version();
	}

	/**
	 * Plugin deactivation callback
	 * @return void
	 */
	public static function on_uninstall(): void {
		$this->check_version();
	}

	/**
	 * Resets things nesessary for plugin to work correctly
	 * @return void
	 */
	protected function refresh(): void {
		flush_rewrite_rules();
	}

	/**
	 * Gets the most recent commit version
	 * @param string $branch Git branch
	 * @return string|null
	 */
	protected function get_current_git_commit( string $branch = 'main' ): ?string {
		$path = "{$this->root_dir}/.git/refs/heads/{$branch}";
		if ( !file_exists( $path ) ) {
			return null;
		}
		$hash = file_get_contents( $path );
		return $hash;
	}

	/**
	 * Checks if the app version matches the previously stored one
	 * in the database
	 * @return void
	 */
	protected function check_version(): void {
		$persisted_version = $this->option_repository->show( 'version' );
		if ( $this->version == $persisted_version || !isset( $this->version ) || empty( $this->version ) ) {
			return;
		}
		$this->refresh();
		$this->option_repository->update( array(
			'version' => $this->version,
		) );
	}

	/**
	 * Checks if integration can connect
	 * @return void
	 */
	protected function check_connection(): void {
		$settings_updated = $this->integration_settings->get_settings_updated();
		if ( !$settings_updated ) {
			return;
		}
		$sources = $this->client->getProvisionalSourceList();
		$can_connect = ( is_array( $sources ) );
		$this->integration_settings_repository->update( array(
			'settings_updated' => false,
			'can_connect'      => $can_connect,
		) );
	}
}
