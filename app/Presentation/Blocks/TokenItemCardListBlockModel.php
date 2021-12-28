<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;

use Tokenly\Wp\Interfaces\Presentation\Components\TokenItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class TokenItemCardListBlockModel extends BlockModel implements TokenItemCardListBlockModelInterface {
	protected $card_token_item_component_model;
	protected $user_service;

	public function __construct(
		TokenItemCardComponentModelInterface $token_item_card_component_model,
		UserServiceInterface $user_service
	) {
		$this->token_item_card_component_model = $token_item_card_component_model;
		$this->user_service = $user_service;
	}

	public function prepare( array $data = array() ) {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		$user = $this->user_service->show( array(
			'id' => $user_id,
		) );
		if ( !$user ) {
			return false;
		}
		$user->load( array( 'oauth_user' ) );
		if ( !isset( $user->oauth_user ) ) {
			return false;
		}
		$user->oauth_user->load( array( 'balance.token_meta' ) );
		$balances = $user->oauth_user->balance;
		$token_items = array();
		foreach ( ( array ) $balances as $balance ) {
			$token_items[] = $this->token_item_card_component_model->prepare( array( 'balance' => $balance, ) );
		}
		return array(
			'token_items' => $token_items,
		);
	}
}
