<?php

use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface
	as CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface
	as CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\VendorControllerInterface
	as CreditVendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface
	as TokenAddressControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface
	as TokenPromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface
	as TokenSourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\VendorControllerInterface
	as TokenVendorControllerInterface;

return function(
		AuthControllerInterface $auth_controller,
		CreditGroupControllerInterface $credit_group_controller,
		CreditTransactionControllerInterface $credit_transaction_controller,
		CreditVendorControllerInterface $credit_vendor_controller,
		TokenAddressControllerInterface $token_address_controller,
		TokenPromiseControllerInterface $token_promise_controller,
		TokenSourceControllerInterface $token_source_controller,
		TokenVendorControllerInterface $token_vendor_controller,
		SettingsControllerInterface $settings_controller,
		UserControllerInterface $user_controller
	) {
		return array(
			'authorize-status' => array(
				'path' => '/authorize',
				'methods'             => 'GET',
				'callback'            => array( $auth_controller, 'show' ),
				'permission_callback' => function () {
					return current_user_can( 'read' );
				},
			),
			'credit_group_account_index' => array(
				'path' => '/credit/group/{group}/account',
				'methods'             => 'GET',
				'callback'            => array(
					$credit_group_controller, 'account_index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_group_show' => array(
				'path' => '/credit/group/{group}',
				'methods'             => 'GET',
				'callback'            => array(
					$credit_group_controller, 'show'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_group_whitelist_update' => array(
				'path' => '/credit/group-whitelist',
				'methods'             => 'PUT',
				'callback'            => array(
					$credit_group_controller, 'group_whitelist_update'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_group_update' => array(
				'path' => '/credit/group/{group}',
				'methods'             => 'PUT',
				'callback'            => array(
					$credit_group_controller, 'update'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_group_index' => array(
				'path' => '/credit/group',
				'methods'             => 'GET',
				'callback'            => array(
					$credit_group_controller, 'index'
				),
				'permission_callback' => function () {
					return true;
				},
			),
			'credit_group_store' => array(
				'path' => '/credit/group',
				'methods'             => 'POST',
				'callback'            => array(
					$credit_group_controller, 'store'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_transaction_index' => array(
				'path' => '/credit/transaction',
				'methods'             => 'GET',
				'callback'            => array(
					$credit_transaction_controller, 'index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_transaction_store' => array(
				'path' => '/credit/transaction',
				'methods'             => 'POST',
				'callback'            => array(
					$credit_transaction_controller, 'store'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_vendor_debit' => array(
				'path' => '/credit/vendor/debit',
				'methods'             => 'POST',
				'callback'            => array(
					$credit_vendor_controller, 'debit'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'credit_vendor_credit' => array(
				'path' => '/credit/vendor/credit',
				'methods'             => 'POST',
				'callback'            => array(
					$credit_vendor_controller, 'credit'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_balance_index' => array(
				'path' => '/token/address/{id}/balance',
				'methods'             => 'GET',
				'callback'            => array(
					$token_address_controller, 'balance_index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_verify' => array(
				'path' => '/token/address/{address}/verify',
				'methods'             => 'PUT',
				'callback'            => array(
					$token_address_controller, 'verify'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_show' => array(
				'path' => '/token/address/{address}',
				'methods'             => 'GET',
				'callback'            => array(
					$token_address_controller, 'show'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_update' => array(
				'path' => '/token/address/{address}',
				'methods'             => 'PUT',
				'callback'            => array(
					$token_address_controller, 'update'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_destroy' => array(
				'path' => '/token/address/{address}',
				'methods'             => 'DELETE',
				'callback'            => array(
					$token_address_controller, 'destroy'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_index' => array(
				'path' => '/token/address',
				'methods'             => 'GET',
				'callback'            => array(
					$token_address_controller, 'index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_address_store' => array(
				'path' => '/token/address',
				'methods'             => 'POST',
				'callback'            => array(
					$token_address_controller, 'store'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_destroy' => array(
				'path' => '/token/address/{address}',
				'methods'             => 'DELETE',
				'callback'            => array(
					$token_address_controller, 'destroy'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_show' => array(
				'path' => '/token/promise/{promise}',
				'methods'             => 'GET',
				'callback'            => array(
					$token_promise_controller, 'show'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_index' => array(
				'path' => '/token/promise',
				'methods'             => 'GET',
				'callback'            => array(
					$token_promise_controller, 'index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_update' => array(
				'path' => '/token/promise/{promise}',
				'methods'             => 'PUT',
				'callback'            => array(
					$token_promise_controller, 'update'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_store' => array(
				'path' => '/token/promise',
				'methods'             => 'POST',
				'callback'            => array(
					$token_promise_controller, 'store'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_promise_destroy' => array(
				'path' => '/token/promise/{promise}',
				'methods'             => 'DELETE',
				'callback'            => array(
					$token_promise_controller, 'destroy'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_vendor_promise' => array(
				'path' => '/token/vendor/promise',
				'methods'             => 'POST',
				'callback'            => array(
					$token_vendor_controller, 'promise'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_source_show' => array(
				'path' => '/token/source/{source}',
				'methods'             => 'GET',
				'callback'            => array(
					$token_source_controller, 'show'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_source_update' => array(
				'path' => '/token/source/{source}',
				'methods'             => 'PUT',
				'callback'            => array(
					$token_source_controller, 'update'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_source_destroy' => array(
				'path' => '/token/source/{source}',
				'methods'             => 'DELETE',
				'callback'            => array(
					$token_source_controller, 'destroy'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_source_index' => array(
				'path' => '/token/source',
				'methods'             => 'GET',
				'callback'            => array(
					$token_source_controller, 'index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_source_store' => array(
				'path' => '/token/source',
				'methods'             => 'POST',
				'callback'            => array(
					$token_source_controller, 'store'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'token_whitelist_update' => array(
				'path' => '/token/whitelist',
				'methods'             => 'PUT',
				'callback'            => array(
					$settings_controller, 'update_token_whitelist'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'user_credit_balance_show' => array(
				'path' => '/user/{id}/credit/balance/{group}',
				'methods'             => 'GET',
				'callback'            => array(
					$user_controller, 'credit_balance_show'
				),
				'permission_callback' => function () {
					return true;
				},
			),
			'user_credit_balance_index' => array(
				'path' => '/user/{id}/credit/balance',
				'methods'             => 'GET',
				'callback'            => array(
					$user_controller, 'credit_balance_index'
				),
				'permission_callback' => function () {
					return true;
				},
			),
			'user_token_balance_show' => array(
				'path' => '/user/{id}/token/balance/{asset}',
				'methods'             => 'GET',
				'callback'            => array(
					$user_controller, 'token_balance_show'
				),
				'permission_callback' => function () {
					return true;
				},
			),
			'user_token_balance_index' => array(
				'path' => '/user/{id}/token/balance',
				'methods'             => 'GET',
				'callback'            => array(
					$user_controller, 'token_balance_index'
				),
				'permission_callback' => function () {
					return true;
				},
			),
			'user_token_address_index' => array(
				'path' => '/user/{id}/token/address',
				'methods'             => 'GET',
				'callback'            => array(
					$user_controller, 'token_address_index'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'user_show' => array(
				'path' => '/user/{id}',
				'methods'             => 'GET',
				'callback'            => array( $user_controller, 'show' ),
				'permission_callback' => function (
					\WP_REST_Request $request
				) {
					$id = $request->get_param( 'id' );
					if (
						current_user_can( 'administrator' ) === false &&
						$id != 'me'
					) {
						return false;
					}
					return true;
				},
			),
			'user_index' => array(
				'path' => '/user',
				'methods'             => 'GET',
				'callback'            => array( $user_controller, 'index' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'integration_settings_show' => array(
				'path' => "/settings/integration",
				'methods'             => 'GET',
				'callback'            => array(
					$settings_controller, 'show_integration'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'settings_show_oauth' => array(
				'path' => "/settings/oauth",
				'methods'             => 'GET',
				'callback'            => array(
					$settings_controller, 'show_oauth'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'settings_show_tca' => array(
				'path' => "/settings/tca",
				'methods'             => 'GET',
				'callback'            => array(
					$settings_controller, 'show_tca'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'settings_update_integration' => array(
				'path' => '/settings/integration',
				'methods'             => 'PUT',
				'callback'            => array(
					$settings_controller, 'update_integration'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'settings_update_oauth' => array(
				'path' => '/settings/oauth',
				'methods'             => 'PUT',
				'callback'            => array(
					$settings_controller, 'update_oauth'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
			'settings_update_tca' => array(
				'path' => '/settings/tca',
				'methods'             => 'PUT',
				'callback'            => array(
					$settings_controller, 'update_tca'
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			),
		);
};
