<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Repositories\SettingsRepository;

class ButtonLogoutComponent extends Component {
	public $settings_repository;
	
	public function __construct(
		Environment $twig,
		SettingsRepository $settings_repository
	) {
		parent::__construct( $twig );
		$this->settings_repository = $settings_repository;
	}

	public function render() {
		if ( $this->settings_repository->is_configured() === false ) {
			return;
		}
		if ( is_user_logged_in() === false ) {
			return;
		}
		$logo = file_get_contents( plugin_dir_url( __FILE__ ) . '../../resources/images/tokenly_logo.svg' );
		$html = $this->twig->render( 'components/ButtonLogoutComponent.twig', array(
			'label' => 'Logout',
			'url'   => wp_logout_url(),
			'logo'  => $logo,
		) );
		return $html;
	}
}
