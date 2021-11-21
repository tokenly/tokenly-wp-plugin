<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

class ButtonLogoutComponent extends Component {
	public $settings;
	
	public function __construct(
		Environment $twig,
		IntegrationInterface $integration
	) {
		parent::__construct( $twig );
		$this->integration = $integration;
	}

	public function render() {
		if ( $this->integration->can_connect() === false ) {
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
