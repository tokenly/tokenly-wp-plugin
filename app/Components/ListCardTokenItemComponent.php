<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Components\CardTokenItemComponent; 
use Tokenly\Wp\Components\Component;
use Twig\Environment;

class ListCardTokenItemComponent extends Component {
	public $card_token_item_component;

	public function __construct(
		Environment $twig,
		CardTokenItemComponent $card_token_item_component
	) {
		parent::__construct( $twig );
		$this->card_token_item_component = $card_token_item_component;
	}

	public function render( $data ) {
		$balances = $data['balances'] ?? null;

		$html_token_items = '';
		foreach ( $balances as $balance ) {
			$html_token_items .= $this->card_token_item_component->render( array( 'balance' => $balance, ) );
		}
		$html = $this->twig->render( 'components/ListCardTokenItemComponent.html', array(
			'token_items' => $html_token_items,
		) );
		return $html;
	}
}