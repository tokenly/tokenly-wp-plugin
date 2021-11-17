<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Blocks\ListCardTokenItemBlock;
use Tokenly\Wp\Blocks\UserInfoBlock;
use Tokenly\Wp\Views\View;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class UserView extends View {
	protected $balances = array();
	protected $user_repository;

	public function __construct(
		Environment $twig,
		UserInfoBlock $user_info_block,
		ListCardTokenItemBlock $list_card_token_item_block,
		UserRepositoryInterface $user_repository
	) {
		parent::__construct( $twig );
		$this->list_card_token_item_block = $list_card_token_item_block;
		$this->user_info_block = $user_info_block;
		$this->user_repository = $user_repository;
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
		$user = $this->user_repository->show( array(
			'id' => get_query_var( 'tokenpass_user_id' ),
		) );
		$html_user_info_block = $this->user_info_block->render(
			array(
				'user' => $user,
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

	protected function render_header() {
		ob_start();
			get_header();
		return ob_get_clean();
	}

	protected function render_footer() {
		ob_start();
			get_footer();
		return ob_get_clean();
	}
}
