<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Components\ListCardTokenItem;

class UserView {
	public $balances = array();

	public function __construct( $data ) {
		$this->balances = $data['balances'] ?? null;
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

	public function render() {
		$html_header = $this->render_header();
		$html_footer = $this->render_footer();
		$html_block_token_list = new ListCardTokenItem(
			array(
				'balances' => $this->balances,
			)
		);
		$html_block_token_list = $html_block_token_list->render();
		$html = "
			{$html_header}
			</div>
			<main id='site-content' class='tokenly-page' role='main'>
				<div class='tokenly-component spacer lg'></div>
				{$html_block_token_list}
				<div class='tokenly-component spacer lg'></div>
			</main>
			<div>
			{$html_footer}
		";
		return $html;
	}
}