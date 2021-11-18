<?php

namespace Tokenly\Wp\Blocks;

use Tokenly\Wp\Components\CardTokenItemComponent; 
use Tokenly\Wp\Components\Component;
use Twig\Environment;

class ListCardTokenItemBlock extends Component {
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
		foreach ( ( array ) $balances as $balance ) {
			$html_token_items .= $this->card_token_item_component->render( array( 'balance' => $balance, ) );
		}
		$html = $this->twig->render( 'blocks/ListCardTokenItemBlock.twig', array(
			'token_items' => $html_token_items,
		) );
		return $html;
	}
}
