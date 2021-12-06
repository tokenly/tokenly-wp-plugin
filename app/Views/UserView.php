<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Blocks\ListCardTokenItemBlock;
use Tokenly\Wp\Blocks\UserInfoBlock;
use Tokenly\Wp\Views\WebView;
use Twig\Environment;

class UserView extends WebView {
	protected $name = 'user';

	public function __construct(
		Environment $twig,
		UserInfoBlock $user_info_block,
		ListCardTokenItemBlock $list_card_token_item_block
	) {
		parent::__construct( $twig );
		$this->list_card_token_item_block = $list_card_token_item_block;
		$this->user_info_block = $user_info_block;
	}

	public function render_content( array $data = array() ) {
		$html_list_card_token_item_block = '';
		if ( isset( $data['balance'] ) ) {
			$html_list_card_token_item_block = $this->list_card_token_item_block->render(
				array(
					'balance' => $data['balance'],
				)
			);
		}
		$html_user_info_block = '';
		if ( isset( $data['user'] ) ) {
			$html_user_info_block = $this->user_info_block->render(
				array(
					'user' => $data['user'],
				)
			);
		}
		$html = $this->twig->render( 'User.twig', array(
			'list_card_token_block'  => $html_list_card_token_item_block,
			'user_info_block'        => $html_user_info_block,
		) );
		return $html;
	}
}
