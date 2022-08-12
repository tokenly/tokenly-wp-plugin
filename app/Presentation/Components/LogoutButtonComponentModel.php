<?php

namespace Tokenly\Wp\Presentation\Components;

use Tokenly\Wp\Presentation\Components\ComponentModel;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;

class LogoutButtonComponentModel extends ComponentModel
	implements LogoutButtonComponentModelInterface
{
	protected string $root_dir;
	protected string $namespace;
	protected IntegrationSettingsInterface $integration_settings;
	
	public function __construct(
		string $root_dir,
		string $namespace,
		IntegrationSettingsRepositoryInterface $integration_setttings_repository
	) {
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->integration_settings = 
			$integration_setttings_repository->show();
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$can_connect = $this->integration_settings->can_connect;
		$is_logged_in = is_user_logged_in();
		$path = "{$this->root_dir}/resources/images/tokenly_logo.svg";
		$logo = file_get_contents( $path );
		return array(
			'label' => 'Logout',
			'logo'  => $logo,
			'url'   => wp_logout_url(),
			'can_connect'  => $can_connect,
			'is_logged_in' => $is_logged_in,
			'namespace'    => $this->namespace,
		);
	}
}
