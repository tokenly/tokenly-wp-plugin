<?php

use Tokenly\Wp\Interfaces\Controllers\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\GroupControllerInterface
	as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\TransactionControllerInterface
	as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\VendorControllerInterface
	as CreditVendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\AddressControllerInterface
	as TokenAddressControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\VendorControllerInterface
	as TokenVendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\PromiseControllerInterface
	as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\SourceControllerInterface
	as TokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\WhitelistControllerInterface
	as TokenWhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\DashboardPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\SettingsPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\UserPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\GroupPolicyInterface
	as CreditGroupPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\TransactionPolicyInterface
	as CreditTransactionPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\VendorPolicyInterface
	as CreditVendorPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\AddressPolicyInterface
	as TokenAddressPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\VendorPolicyInterface
	as TokenVendorPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\PromisePolicyInterface
	as TokenPromisePolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\SourcePolicyInterface
	as TokenSourcePolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\WhitelistPolicyInterface
	as TokenWhitelistPolicyInterface;
return function(
		string $namespace,
		string $brand,
		string $logo,
		SettingsControllerInterface $settings_controller,
		TokenAddressControllerInterface $token_address_controller,
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		TokenWhitelistControllerInterface $token_whitelist_controller,
		TokenVendorControllerInterface $token_vendor_controller,
		UserControllerInterface $user_controller,
		DashboardControllerInterface $dashboard_controller,
		CreditGroupControllerInterface $credit_group_controller,
		CreditTransactionControllerInterface $credit_transaction_controller,
		CreditVendorControllerInterface $credit_vendor_controller,
		SettingsPolicyInterface $settings_policy,
		TokenAddressPolicyInterface $token_address_policy,
		TokenPromisePolicyInterface $token_promise_policy,
		TokenSourcePolicyInterface $token_source_policy,
		TokenWhitelistPolicyInterface $token_whitelist_policy,
		TokenVendorPolicyInterface $token_vendor_policy,
		UserPolicyInterface $user_policy,
		DashboardPolicyInterface $dashboard_policy,
		CreditGroupPolicyInterface $credit_group_policy,
		CreditTransactionPolicyInterface $credit_transaction_policy,
		CreditVendorPolicyInterface $credit_vendor_policy
	) {
		return array(
			$namespace => array(
				'page_title'  => $brand,
				'menu_title'  => $brand,
				'menu_slug'   => $namespace,
				'callable'    => array( $dashboard_controller, 'show' ),
				'capability'  => 'read',
				'icon_url'    => $logo,
				'position'    => 3,
				'policy'      => function() {
					return true;
				},
				'subroutes'   => array(
					'dashboard' => array(
						'page_title'  => 'Dashboard',
						'menu_title'  => '
							<div class="with-icon">
								<span>Dashboard</span>
								<span 
									class="dashicons dashicons-external"
								></span>
							</div>',
						'menu_slug'   => 'dashboard',
						'policy'      => function() {
							return true;
						},
						'capability'  => 'use_tokenpass',
					),
					'inventory' => array(
						'page_title'  => 'Inventory',
						'menu_title'  => '
							<div class="with-icon">
								<span>Inventory</span>
								<span
									class="dashicons dashicons-external"
								></span>
							</div>',
						'menu_slug'   => 'inventory',
						'policy'      => function() {
							return true;
						},
						'capability'  => 'read',
					),
					'credit_vendor' => array(
						'page_title'  => 'Credit Vendor',
						'menu_title'  => 'Credit Vendor',
						'menu_slug'   => 'credit-vendor',
						'callable'    => array(
							$credit_vendor_controller, 'show'
						),
						'policy'      => array(
							$credit_vendor_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Listing',
						'menu_title'  => 'Credit Group Listing',
						'menu_slug'   => 'credit-group-index',
						'callable'    => array(
							$credit_group_controller, 'index'
						),
						'policy'      => array(
							$credit_group_policy, 'index'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_store' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Creator',
						'menu_title'  => 'Credit Group Creator',
						'menu_slug'   => 'credit-group-store',
						'callable'    => array(
							$credit_group_controller, 'store'
						),
						'policy'      => array(
							$credit_group_policy, 'store'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_edit' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Editor',
						'menu_title'  => 'Credit Group Editor',
						'menu_slug'   => 'credit-group-edit',
						'callable'    => array(
							$credit_group_controller, 'edit'
						),
						'policy'      => array(
							$credit_group_policy, 'edit'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_show' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Details',
						'menu_title'  => 'Credit Group Details',
						'menu_slug'   => 'credit-group-show',
						'callable'    => array(
							$credit_group_controller, 'show'
						),
						'policy'      => array(
							$credit_group_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_account_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Account Listing',
						'menu_title'  => 'Credit Group Account Listing',
						'menu_slug'   => 'credit-group-account-index',
						'callable'    => array(
							$credit_group_controller, 'account_index'
						),
						'policy'      => array(
							$credit_group_policy, 'account_index'
						),
						'capability'  => 'manage_options',
					),
					'credit_group_whitelist_edit' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Group Whitelist Editor',
						'menu_title'  => 'Credit Group Whitelist Editor',
						'menu_slug'   => 'credit-group-whitelist-edit',
						'callable'    => array(
							$credit_group_controller, 'whitelist_edit'
						),
						'policy'      => array(
							$credit_group_policy, 'whitelist_edit'
						),
						'capability'  => 'manage_options',
					),
					'credit_transaction_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Transaction Listing',
						'menu_title'  => 'Credit Transaction Listing',
						'menu_slug'   => 'credit-transaction-index',
						'callable'    => array(
							$credit_transaction_controller, 'index'
						),
						'policy'      => array(
							$credit_transaction_policy, 'index'
						),
						'capability'  => 'manage_options',
					),
					'credit_transaction_store' => array(
						'parent_slug' => false,
						'page_title'  => 'Credit Transaction Creator',
						'menu_title'  => 'Credit Transaction Creator',
						'menu_slug'   => 'credit-transaction-store',
						'callable'    => array(
							$credit_transaction_controller, 'store'
						),
						'policy'      => array(
							$credit_transaction_policy, 'store'
						),
						'capability'  => 'manage_options',
					),
					'token_address_balance_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Balance Listing',
						'menu_title'  => 'Token Address Balance Listing',
						'menu_slug'   => 'token-address-balance-index',
						'callable'    => array(
							$token_address_controller, 'balance_index'
						),
						'policy'      => array(
							$token_address_policy, 'balance_index'
						),
						'capability'  => 'manage_options',
					),
					'token_address_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Listing',
						'menu_title'  => 'Token Address Listing',
						'menu_slug'   => 'token-address-index',
						'callable'    => array(
							$token_address_controller, 'index'
						),
						'policy'      => array(
							$token_address_policy, 'index'
						),
						'capability'  => 'manage_options',
					),
					'token_address_show' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Display',
						'menu_title'  => 'Token Address Display',
						'menu_slug'   => 'token-address-show',
						'callable'    => array(
							$token_address_controller, 'show'
						),
						'policy'      => array(
							$token_address_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'token_address_store' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Creator',
						'menu_title'  => 'Token Address Creator',
						'menu_slug'   => 'token-address-store',
						'callable'    => array(
							$token_address_controller, 'store'
						),
						'policy'      => array(
							$token_address_policy, 'store'
						),
						'capability'  => 'manage_options',
					),
					'token_address_edit' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Editor',
						'menu_title'  => 'Token Address Editor',
						'menu_slug'   => 'token-address-edit',
						'callable'    => array(
							$token_address_controller, 'edit'
						),
						'policy'      => array(
							$token_address_policy, 'edit'
						),
						'capability'  => 'manage_options',
					),
					'token_address_verify' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Address Verifier',
						'menu_title'  => 'Token Address Verifier',
						'menu_slug'   => 'token-address-verify',
						'callable'    => array(
						 	$token_address_controller, 'verify'
						),
						'policy'      => array(
							$token_address_policy, 'verify'
						),
						'capability'  => 'manage_options',
					),
					'token_vendor' => array(
						'page_title'  => 'Token Vendor',
						'menu_title'  => 'Token Vendor',
						'menu_slug'   => 'token-vendor',
						'callable'    => array(
							$token_vendor_controller, 'show'
						),
						'policy'      => array(
							$token_vendor_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'token_promise_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Promise Listing',
						'menu_title'  => 'Token Promise Listing',
						'menu_slug'   => 'token-promise-index',
						'callable'    => array(
							$token_promise_controller, 'index'
						),
						'policy'      => array(
							$token_promise_policy, 'index'
						),
						'capability'  => 'manage_options',
					),
					'token_promise_show' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Promise Details',
						'menu_title'  => 'Token Promise Details',
						'menu_slug'   => 'token-promise-show',
						'callable'    => array(
							$token_promise_controller, 'show'
						),
						'policy'      => array(
							$token_promise_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'token_promise_store' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Promise Creator',
						'menu_title'  => 'Token Promise Creator',
						'menu_slug'   => 'token-promise-store',
						'callable'    => array(
							$token_promise_controller, 'store'
						),
						'policy'      => array(
							$token_promise_policy, 'store'
						),
						'capability'  => 'manage_options',
					),
					'token_promise_edit' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Promise Editor',
						'menu_title'  => 'Token Promise Editor',
						'menu_slug'   => 'token-promise-edit',
						'callable'    => array(
							$token_promise_controller, 'edit'
						),
						'policy'      => array(
							$token_promise_policy, 'edit'
						),
						'capability'  => 'manage_options',
					),
					'token_source_index' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Source Listing',
						'menu_title'  => 'Token Source Listing',
						'menu_slug'   => 'token-source-index',
						'callable'    => array(
							$token_source_controller, 'index'
						),
						'policy'      => array(
							$token_source_policy, 'index'
						),
						'capability'  => 'manage_options',
					),
					'token_source_show' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Source Details',
						'menu_title'  => 'Token Source Details',
						'menu_slug'   => 'token-source-show',
						'callable'    => array(
							$token_source_controller, 'show'
						),
						'policy'      => array(
							$token_source_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
					'token_source_store' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Source Creator',
						'menu_title'  => 'Token Source Creator',
						'menu_slug'   => 'token-source-store',
						'callable'    => array(
							$token_source_controller, 'store'
						),
						'policy'      => array(
							$token_source_policy, 'store'
						),
						'capability'  => 'manage_options',
					),
					'token_source_edit' => array(
						'parent_slug' => false,
						'page_title'  => 'Token Source Editor',
						'menu_title'  => 'Token Source Editor',
						'menu_slug'   => 'token-source-edit',
						'callable'    => array(
							$token_source_controller, 'edit'
						),
						'policy'      => array(
							$token_source_policy, 'edit'
						),
						'capability'  => 'manage_options',
					),
					'token_whitelist_edit' => array(
						'parent_slug' => 'tokenly-token-vendor',
						'page_title'  => 'Token Whitelist Editor',
						'menu_title'  => 'Token Whitelist Editor',
						'menu_slug'   => 'token-whitelist-edit',
						'callable'    => array(
							$token_whitelist_controller, 'edit'
						),
						'policy'      => array(
							$token_whitelist_policy, 'edit'
						),
						'capability'  => 'manage_options',
					),
					'user_credit_balance_index' => array(
						'parent_slug' => false,
						'page_title'  => 'User Credit Balance Listing',
						'menu_title'  => 'User Credit Balance Listing',
						'menu_slug'   => 'user-credit-balance-index',
						'callable'    => array(
							$user_controller, 'credit_balance_index'
						),
						'policy'      => array(
							$user_policy, 'credit_balance_index'
						),
						'capability'  => 'read',
					),
					'user_token_balance_index' => array(
						'parent_slug' => false,
						'page_title'  => 'User Token Balance Listing',
						'menu_title'  => 'User Token Balance Listing',
						'menu_slug'   => 'user-token-balance-index',
						'callable'    => array(
							$user_controller, 'token_balance_index'
						),
						'policy'      => array(
							$user_policy, 'token_balance_index'
						),
						'capability'  => 'read',
					),
					'settings' => array(
						'page_title'  => 'Settings',
						'menu_title'  => 'Settings',
						'menu_slug'   => 'settings',
						'callable'    => array(
							$settings_controller, 'show'
						),
						'policy'      => array(
							$settings_policy, 'show'
						),
						'capability'  => 'manage_options',
					),
				),
			),
		);
};
