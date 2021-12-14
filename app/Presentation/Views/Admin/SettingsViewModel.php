<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class SettingsViewModel extends ViewModel implements SettingsViewModelInterface {
	protected $integration;
	protected $tca_settings;
	protected $oauth_settings;
	protected $oauth_callback_route;
	
	public function __construct(
		IntegrationInterface $integration,
		TcaSettingsInterface $tca_settings,
		OauthSettingsInterface $oauth_settings,
		string $oauth_callback_route
	) {
		$this->integration = $integration;
		$this->tca_settings = $tca_settings;
		$this->oauth_settings = $oauth_settings;
		$this->oauth_callback_route = $oauth_callback_route;
	}
	
	public function prepare( array $data = array() ) {
		$integration_settings = $this->integration->settings->to_array();
		$tca_settings = $this->tca_settings->to_array();
		$oauth_settings = $this->oauth_settings->to_array();
		$post_types = $this->tca_settings->get_available_post_types();
		$taxonomies = $this->tca_settings->get_available_taxonomies();
		return array(
			'integration_settings' => $integration_settings,
			'integration_data'     => array(
				'app_homepage_url'  => get_site_url(),
				'client_auth_url'   => $this->oauth_callback_route,
				'status'            => $this->integration->can_connect(),
			),
			'tca_settings'          => $tca_settings,
			'tca_data'              => array(
				'post_types' => $post_types,
				'taxonomies' => $taxonomies,
			),
			'oauth_settings'        => $oauth_settings,
		);
	}

}
