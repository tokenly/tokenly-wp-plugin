<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\SettingsInterface;

class ButtonLoginComponent extends Component {
	public $settings;
	
	public function __construct(
		Environment $twig,
		SettingsInterface $settings
	) {
		parent::__construct( $twig );
		$this->settings = $settings;
	}

	public function render() {
		if ( $this->settings->is_configured() === false ) {
			return;
		}
		if ( is_user_logged_in() === true ) {
			return;
		}
		$logo = file_get_contents( plugin_dir_url( __FILE__ ) . '../../resources/images/tokenly_logo.svg' );
		$html = $this->twig->render( 'components/ButtonLoginComponent.twig', array(
			'label' => 'Login with Tokenpass',
			'logo'  => $logo,
		) );
		return $html;
	}
}
