<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Views\Admin\SettingsView;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

/**
 * Serves the admin settings view
 */
class SettingsController implements SettingsControllerInterface {
	protected $settings_view;
	protected $integration;
	protected $oauth_callback_route;
	protected $tca_settings;

	public function __construct(
		SettingsView $settings_view,
		IntegrationInterface $integration,
		TcaSettingsInterface $tca_settings,
		string $oauth_callback_route
	) {
		$this->settings_view = $settings_view;
		$this->integration = $integration;
		$this->oauth_callback_route = $oauth_callback_route;
		$this->tca_settings = $tca_settings;
	}

	public function show() {
		$integration_settings = $this->integration->settings->to_array();
		$post_type_objects = get_post_types( array(), 'objects' );
		$post_types = array();
		foreach ( $post_type_objects as $post_type_object ) {
			$post_types[ $post_type_object->name ] = $post_type_object->label; 
		}
		$tca_settings = $this->tca_settings->to_array();
		$render = $this->settings_view->render( array(
			'integration_settings' => $integration_settings,
			'integration_data'     => array(
				'app_homepage_url'  => get_site_url(),
				'client_auth_url'   => $this->oauth_callback_route,
				'status'            => $this->integration->can_connect(),
			),
			'tca_settings'          => $tca_settings,
			'tca_data'              => array(
				'post_types' => $post_types,
			),
		) );
		return $render;
	}
}
