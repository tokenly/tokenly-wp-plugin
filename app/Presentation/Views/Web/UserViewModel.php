<?php

namespace Tokenly\Wp\Presentation\Views\Web;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class UserViewModel extends ViewModel implements UserViewModelInterface {
	protected $name = 'user';
	protected $user_service;
	protected $credit_group_service;
	protected $current_user;
	protected $user_info_block_model;
	protected $token_item_card_list_block_model;
	protected $app_credit_item_card_list_block_model;
	
	public function __construct(
		UserServiceInterface $user_service,
		CreditGroupServiceInterface $credit_group_service,
		CurrentUserInterface $current_user,
		UserInfoBlockModelInterface $user_info_block_model,
		TokenItemCardListBlockModelInterface $token_item_card_list_block_model,
		AppCreditItemCardListBlockModelInterface $app_credit_item_card_list_block_model
	) {
		$this->user_service = $user_service;
		$this->current_user = $current_user;
		$this->credit_group_service = $credit_group_service;
		$this->user_info_block_model = $user_info_block_model;
		$this->token_item_card_list_block_model = $token_item_card_list_block_model;
		$this->app_credit_item_card_list_block_model = $app_credit_item_card_list_block_model;
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
		$token_item_card_list_block_data = null;
		if ( $balance && is_object( $balance ) ) {
			$token_item_card_list_block_data = $this->token_item_card_list_block_model->prepare(
				array(
					'balance' => $balance,
				)
			);
		}
		$app_credit_item_card_list_block_data = null;
		if ( $credit_accounts && $credit_groups ) {
			$app_credit_item_card_list_block_data = $this->app_credit_item_card_list_block_model->prepare(
				array(
					'credit_accounts' => $credit_accounts,
					'credit_groups'   => $credit_groups,
				)
			);
		}
		$user_info_block_data = null;
		// if ( isset( $data['user'] ) ) {
		// 	$user_info_block_data = $this->user_info_block_model->render(
		// 		array(
		// 			'user' => $data['user'],
		// 		)
		// 	);
		// }
		return array(
			'user_info_block'              => $user_info_block_data,
			'token_inventory_block_data'   => $token_item_card_list_block_data,
			'credit_inventory_block_data'  => $app_credit_item_card_list_block_data,
		);
	}
}
