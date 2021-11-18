<?php

namespace Tokenly\Wp\Blocks;

use Tokenly\Wp\Components\Component;
use Twig\Environment;

class UserInfoBlock extends Component {
	public $card_token_item_component;

	public function __construct(
		Environment $twig
	) {
		parent::__construct( $twig );
	}

	public function render( $data ) {
		$user = $data['user'] ?? null;
		$html = '';
		if ( $user ) {
			$name = $user->user_nicename;
			$html .= $this->twig->render( 'blocks/UserInfoBlock.twig', array(
				'name' => $name,
			) );
		}
		return $html;
	}
}
