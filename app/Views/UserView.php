<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Components\ListCardTokenItemComponent;
use Tokenly\Wp\Views\View;
use Twig\Environment;

class UserView extends View {
	public $balances = array();

	public function __construct(
		Environment $twig,
		ListCardTokenItemComponent $list_card_token_item_component
	) {
		parent::__construct( $twig );
		$this->list_card_token_item_component = $list_card_token_item_component;
	}

	public function render_header() {
		ob_start();
			get_header();
		return ob_get_clean();
	}

	public function render_footer() {
		ob_start();
			get_footer();
		return ob_get_clean();
	}

	public function render( $data ) {
		$this->balances = $data['balances'] ?? null;
		$html_header = $this->render_header();
		$html_footer = $this->render_footer();
		$html_block_token_list = $this->list_card_token_item_component->render(
			array(
				'balances' => $this->balances,
			)
		);
		$html = $this->twig->render( 'user.html', array(
			'header' => $html_header,
			'footer' => $html_footer,
			'block_token_list' => $html_block_token_list,
		) );
		return $html;
	}
}