<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Blocks\ListCardTokenItemBlock;
use Tokenly\Wp\Blocks\UserInfoBlock;
use Tokenly\Wp\Views\View;
use Twig\Environment;

class UserView extends View {
	public $balances = array();

	public function __construct(
		Environment $twig,
		UserInfoBlock $user_info_block,
		ListCardTokenItemBlock $list_card_token_item_block
	) {
		parent::__construct( $twig );
		$this->list_card_token_item_block = $list_card_token_item_block;
		$this->user_info_block = $user_info_block;
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
		$html_list_card_token_item_block = $this->list_card_token_item_block->render(
			array(
				'balances' => $this->balances,
			)
		);
		$html_user_info_block = $this->user_info_block->render(
			array(
				'user' => wp_get_current_user(),
			)
		);
		$html = $this->twig->render( 'User.twig', array(
			'header' => $html_header,
			'footer' => $html_footer,
			'list_card_token_block' => $html_list_card_token_item_block,
			'user_info_block'       => $html_user_info_block,
		) );
		return $html;
	}
}
