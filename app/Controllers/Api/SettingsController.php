<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;

use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\WhitelistRepositoryInterface
	as TokenWhitelistRepositoryInterface;

/**
 * Handles the integration settings REST API endpoints
 */
class SettingsController implements SettingsControllerInterface {
	protected array $settings;

	public function __construct(
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		OauthSettingsRepositoryInterface $oauth_settings_repository,
		TcaSettingsRepositoryInterface $tca_settings_repository,
		TokenWhitelistRepositoryInterface $token_whitelist_settings_repository
	) {
		$this->settings = array(
			'integration'     => $integration_settings_repository,
			'oauth'           => $oauth_settings_repository,
			'tca'             => $tca_settings_repository,
			'token_whitelist' => $token_whitelist_settings_repository,
		);
	}

	protected $names = array(
		'integration'     => 'Integration',
		'oauth'           => 'Authentication',
		'tca'             => 'TCA',
		'token_whitelist' => 'Token Whitelist',
	);

	public function show_integration(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->show( $request, 'integration' );
	}

	public function show_oauth(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->show( $request, 'oauth' );
	}

	public function show_tca(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->show( $request, 'tca' );
	}

	public function show_whitelist(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->show( $request, 'token_whitelist' );
	}

	public function update_integration(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->update( $request, 'integration' );
	}

	public function update_oauth(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->update( $request, 'oauth' );
	}

	public function update_tca(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->update( $request, 'tca' );
	}

	public function update_token_whitelist(
		\WP_REST_Request $request
	): \WP_REST_Response {
		return $this->update( $request, 'token_whitelist' );
	}

	protected function show(
		\WP_REST_Request $request, string $type
	): \WP_REST_Response {
		return new \WP_REST_Response( $this->settings[ $type ]->to_array() ); 
	}

	protected function update(
		\WP_REST_Request $request, string $type
	): \WP_REST_Response {
		$params = $request->get_params();
		if ( $type == 'integration' ) {
			$params['settings_updated'] = true;
		}
		$this->settings[ $type ]->update( $params );
		$name = $this->names[ $type ];
		$status = "The {$name} settings were successfully updated!";
		return new \WP_REST_Response( array(
			'status' => $status,
		) );
	}
}
