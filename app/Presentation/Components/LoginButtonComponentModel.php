<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;

class LoginButtonComponentModel extends ComponentModel
	implements LoginButtonComponentModelInterface
{
	protected string $root_dir;
	protected string $namespace;
	protected IntegrationSettingsRepositoryInterface $integration_setttings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected OauthSettingsRepositoryInterface $oauth_setttings_repository;
	protected OauthSettingsInterface $oauth_setttings;

	public function __construct(
		IntegrationSettingsRepositoryInterface $integration_setttings_repository,
		OauthSettingsRepositoryInterface $oauth_setttings_repository,
		string $root_dir,
		string $namespace
	) {
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->oauth_setttings_repository = $oauth_setttings_repository;
		$this->oauth_settings = $this->oauth_setttings_repository->show();
		$this->integration_setttings_repository = 
			$integration_setttings_repository;
		$this->integration_settings = 
			$this->integration_setttings_repository->show();
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$label = 'Login with Tokenpass';
		if ( isset( $data['label'] ) ) {
			$label = $data['label'];
		}
		$redirect = $this->oauth_settings->success_url;
		if ( isset( $data['redirect'] ) ) {
			$redirect = $data['redirect'];
		}
		$can_connect = $this->integration_settings->can_connect;
		$is_logged_in = is_user_logged_in();
		$path = "{$this->root_dir}/resources/images/tokenly_logo.svg";
		$logo = file_get_contents( $path );
		$use_single_sign_on = $this->oauth_settings->use_single_sign_on;
		$url = "/{$this->namespace}/oauth/connect";
		if ( $redirect ) {
			$url = add_query_arg(
				"{$this->namespace}_success_url", $redirect, $url
			);
		}
		return array(
			'label'               => $label,
			'logo'                => $logo,
			'url'                 => $url,
			'can_connect'         => $can_connect,
			'is_logged_in'        => $is_logged_in,
			'use_single_sign_on'  => $use_single_sign_on,
			'namespace'           => $this->namespace,
		);
	}
}
