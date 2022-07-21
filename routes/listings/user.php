<?php

use Tokenly\Wp\Interfaces\Presentation\Columns\UserCreditBalanceColumnInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface
	as CreditGroupRepositoryInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

return function(
	UserCreditBalanceColumnInterface $user_credit_balance_column,
	CreditGroupRepositoryInterface $credit_group_repository,
	string $namespace
	) {
		$columns = function() use (
			$user_credit_balance_column,
			$credit_group_repository
		) {
			$groups = $credit_group_repository->index();
			$columns = array();
			foreach ( ( array ) $groups as $group ) {
				$name = $group->name;
				$uuid = $group->uuid;
				$columns[ "user-credit-balance-{$uuid}" ] = array(
					'id'       => "user-credit-balance",
					'title'    => $name,
					'data'     => array( 'uuid' => $uuid ),
					'callback' => array(
						$user_credit_balance_column,
						'column_callback'
					),
				);
			}
			return $columns;
		};
		$actions = function( UserInterface $user ) use ( $namespace ) {
			if ( !$user->can_connect ) {
				return array();
			}
			$id = $user->ID;
			$base_url = "admin.php?page={$namespace}";
			return array(
				'token_balance'  => array(
					'title' => 'Token Inventory',
					'url'   => admin_url(
						"{$base_url}-user-token-balance-index&id={$id}"
					),
				),
				'credit_balance' => array(
					'title' => 'Credit Inventory',
					'url'   => admin_url(
						"{$base_url}-user-credit-balance-index&id={$id}"
					),
				),
			);
		};
		return array(
			'columns' => $columns,
			'actions' => $actions,
		);
};
