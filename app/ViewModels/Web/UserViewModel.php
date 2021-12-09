<?php

namespace Tokenly\Wp\ViewModels\Web;

use Tokenly\Wp\Blocks\ListCardTokenItemBlockModel;
use Tokenly\Wp\Blocks\ListCardAppCreditItemBlockModel;
use Tokenly\Wp\Blocks\UserInfoBlock;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class UserViewModel {
	protected $name = 'user';
	protected $user_service;
	protected $credit_group_service;
	protected $current_user;
	protected $list_card_token_item_block_model;
	protected $list_card_app_credit_item_block_model;
	
	public function __construct(
		UserServiceInterface $user_service,
		CreditGroupServiceInterface $credit_group_service,
		CurrentUserInterface $current_user,
		UserInfoBlock $user_info_block,
		ListCardTokenItemBlockModel $list_card_token_item_block_model,
		ListCardAppCreditItemBlockModel $list_card_app_credit_item_block_model
	) {
		$this->user_service = $user_service;
		$this->credit_group_service = $credit_group_service;
		$this->list_card_token_item_block_model = $list_card_token_item_block_model;
		$this->list_card_app_credit_item_block_model = $list_card_app_credit_item_block_model;
		// $this->user_info_block = $user_info_block;
	}

	public function prepare( array $data = array() ) {
		$user_id = $data['user_id'];
		if ( $user_id == 'me' ) {
			$user = $this->current_user;
		} else {
			$user = $this->user_service->show( array(
				'id' => $user_id,
			) );
		}
		if ( !$user ) {
			return false;
		}
		$user->load( array( 'oauth_user' ) );
		if ( !isset( $user->oauth_user ) ) {
			return false;
		}
		$user->oauth_user->load( array( 'address.balance.token_meta', 'credit_account' ) );
		$balance = $user->oauth_user->address->get_combined_balance();
		$credit_accounts = $user->oauth_user->credit_account;
		$credit_groups = $this->credit_group_service->index();
		$render = $this->user_view->render( array(
			'balance'         => $balance,
			'credit_accounts' => $credit_accounts,
			'credit_groups'   => $credit_groups,
			'user'            => $user,
		) );
		$list_card_token_item_block = null;
		if ( isset( $data['balance'] ) ) {
			$list_card_token_item_block = $this->list_card_token_item_block_model->prepare(
				array(
					'balance' => $data['balance'],
				)
			);
		}
		$list_card_app_credit_item_block = null;
		if (
			isset( $data['credit_accounts'] ) &&
			isset( $data['credit_groups'] )
		) {
			$list_card_app_credit_item_block = $this->list_card_app_credit_item_block_model->prepare(
				array(
					'credit_accounts' => $data['credit_accounts'],
					'credit_groups'   => $data['credit_groups'],
				)
			);
		}
		$user_info_block = null;
		// if ( isset( $data['user'] ) ) {
		// 	$html_user_info_block = $this->user_info_block->render(
		// 		array(
		// 			'user' => $data['user'],
		// 		)
		// 	);
		// }
		return array(
			'user_info_block'              => $user_info_block,
			'token_inventory_block_data'   => $list_card_token_item_block,
			'credit_inventory_block_data'  => $list_card_app_credit_item_block,
		);
	}
}
