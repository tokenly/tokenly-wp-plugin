<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;

use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class AppCreditItemCardListBlockModel extends BlockModel implements AppCreditItemCardListBlockModelInterface {
	protected $app_credit_item_card_component_model;
	protected $group_service;
	protected $user_service;

	public function __construct(
		AppCreditItemCardComponentModelInterface $app_credit_item_card_component_model,
		GroupServiceInterface $group_service,
		UserServiceInterface $user_service
	) {
		$this->app_credit_item_card_component_model = $app_credit_item_card_component_model;
		$this->group_service = $group_service;
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
		$user->oauth_user->load( array( 'credit_account' ) );
		$accounts = $user->oauth_user->credit_account;
		$groups = $this->group_service->index();
		$groups->key_by_field( 'uuid' );
		$credit_items = array();
		foreach ( ( array ) $accounts as $key => $account ) {
			$group = null;
			if ( isset( $groups[ $account->group_id ] ) ) {
				$group = $groups[ $account->group_id ];
			}
			$credit_items[] = $this->app_credit_item_card_component_model->prepare( array(
					'group'    => $group,
					'account'  => $account,
				)
			);
		}
		return array(
			'credit_items' => $credit_items,
		);
	}
}
