<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class LoginButtonComponentModel extends ComponentModel implements LoginButtonComponentModelInterface {
	protected $integration;
	protected $root_dir;
	protected $namespace;
	protected $oauth_setttings;

	public function __construct(
		IntegrationInterface $integration,
		OauthSettingsInterface $oauth_setttings,
		string $root_dir,
		string $namespace
	) {
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->integration = $integration;
		$this->oauth_settings = $oauth_setttings;
	}

	public function prepare( array $data = array() ) {
		$label = 'Login with Tokenpass';
		if ( isset( $data['label'] ) ) {
			$label = $data['label'];
		}
		$redirect = $this->oauth_settings->success_url;
		if ( isset( $data['redirect'] ) ) {
			$redirect = $data['redirect'];
		}
		$can_connect = $this->integration->can_connect();
		$is_logged_in = is_user_logged_in();
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		$use_single_sign_on = $this->oauth_settings->use_single_sign_on;
		$url = "/{$this->namespace}/oauth/connect";
		if ( $redirect ) {
			$url = add_query_arg( "{$this->namespace}_success_url", $redirect, $url );
		}
		return array(
			'label'               => $label,
			'logo'                => $logo,
			'url'                 => $url,
			'can_connect'         => $can_connect,
			'is_logged_in'        => $is_logged_in,
			'use_single_sign_on'  => $use_single_sign_on,
		);
	}
}
