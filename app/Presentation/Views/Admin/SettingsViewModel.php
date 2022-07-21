<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;

class SettingsViewModel extends DynamicViewModel
	implements SettingsViewModelInterface
{
	protected IntegrationSettingsInterface $integration_settings;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected OauthSettingsInterface $oauth_settings;
	protected OauthSettingsRepositoryInterface $oauth_settings_repository;
	protected TcaSettingsInterface $tca_settings;
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected string $oauth_callback_route;
	
	public function __construct(
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		OauthSettingsRepositoryInterface $oauth_settings_repository,
		TcaSettingsRepositoryInterface $tca_settings_repository,
		string $oauth_callback_route
	) {
		$this->integration_settings_repository =
			$integration_settings_repository;
		$this->integration_settings = 
			$this->integration_settings_repository->show();
		$this->oauth_settings_repository = $oauth_settings_repository;
		$this->oauth_settings = $this->oauth_settings_repository->show();
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->oauth_callback_route = $oauth_callback_route;
	}
	
	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		$integration_settings = $this->integration_settings->to_array();
		$tca_settings = $this->tca_settings->to_array();
		$oauth_settings = $this->oauth_settings->to_array();
		$post_types = $this->tca_settings->available_post_types;
		$taxonomies = $this->tca_settings->available_taxonomies;
		return array(
			'integration_settings' => $integration_settings,
			'integration_data'     => array(
				'app_homepage_url' => get_site_url(),
				'client_auth_url'  => $this->oauth_callback_route,
				'status'           => $this->integration_settings->can_connect,
			),
			'tca_settings'          => $tca_settings,
			'tca_data'              => array(
				'post_types' => $post_types,
				'taxonomies' => $taxonomies,
			),
			'oauth_settings' => $oauth_settings,
		);
	}

}
