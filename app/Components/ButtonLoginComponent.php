<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\Component;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;

class ButtonLoginComponent extends Component implements ButtonLoginComponentInterface {
	public $integration;
	protected $root_dir;

	public function __construct(
		Environment $twig,
		IntegrationInterface $integration,
		string $root_dir
	) {
		parent::__construct( $twig );
		$this->root_dir = $root_dir;
		$this->integration = $integration;
	}

	public function render() {
		if ( $this->integration->can_connect() === false ) {
			return;
		}
		if ( is_user_logged_in() === true ) {
			return;
		}
		$logo = file_get_contents( $this->root_dir . '/resources/images/tokenly_logo.svg' );
		$html = $this->twig->render( 'components/ButtonLoginComponent.twig', array(
			'label' => 'Login with Tokenpass',
			'logo'  => $logo,
		) );
		return $html;
	}
}
