<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Repositories\SettingsRepository;

class ButtonLoginComponent extends Component {
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
		global $tokenly_routes;
		$api_routes = $tokenly_routes['api'];
		$url;
		if ( $api_routes ) {
			$url = $api_routes['authorize'] ?? null;
		}
		$logo = file_get_contents( plugin_dir_url( __FILE__ ) . '../../resources/images/tokenly_logo.svg' );
		$html = $this->twig->render( 'components/ButtonLoginComponent.twig', array(
			'url'  => $url,
			'logo' => $logo,
		) );
		return $html;
	}
}
