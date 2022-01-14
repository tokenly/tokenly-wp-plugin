<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;

use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

class UserController extends Controller implements UserControllerInterface {
	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}
	
	/**
	 * Gets a collection of users
	 * @param UserCollectionInterface $users Bound users
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function index( UserCollectionInterface $users, \WP_REST_Request $request ) {
		if ( isset( $params['suggestions'] ) ) {
			$users->to_suggestions();
		}
		$users = $users->to_array();
		return $users;
	}

	/**
	 * Gets a single user
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function show( UserInterface $user, \WP_REST_Request $request ) {
		$user = $user->to_array();
		return $user;
	}

	/**
	 * Gets a collection of balance
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function credit_balance_index( UserInterface $user, \WP_REST_Request $request ) {
		$user->load( array( 'oauth_user.credit_account' ) );
		if (
			isset( $user->oauth_user ) &&
			$user->oauth_user instanceof OauthUserInterface === true &&
			isset( $user->oauth_user->credit_account ) &&
			$user->oauth_user->credit_account instanceof AccountCollectionInterface === true
		) {
			$account = $user->oauth_user->credit_account->to_array();
			return $account;
		} else {
			return array();
		}
	}

	/**
	 * Gets a collection of balance
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function token_balance_index( UserInterface $user, \WP_REST_Request $request ) {
		$user->load( array( 'oauth_user.balance.meta' ) );
		if ( !isset( $user->oauth_user ) || $user->oauth_user instanceof OauthUserInterface === false ) {
			return array();
		}
		if ( !isset( $user->oauth_user->balance ) || $user->oauth_user->balance instanceof BalanceCollectionInterface === false ) {
			return array();
		}
		$balance = $user->oauth_user->balance->to_array();
		return $balance;
	}

	/**
	 * Gets a collection of addresses
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function token_address_index( UserInterface $user, \WP_REST_Request $request ) {
		$user->load( array( 'oauth_user.address' ) );
		if (
			isset( $user->oauth_user ) &&
			$user->oauth_user instanceof OauthUserInterface === true &&
			isset( $user->oauth_user->address ) &&
			$user->oauth_user->address instanceof AddressCollectionInterface === true
		) {
			$address = clone $user->oauth_user->address;
			$registered = $request->get_param( 'registered' );
			if ( $registered ) {
				$address->filter_registered();
			}
			$address = $address->to_array();
			return $address;
		} else {
			return array();
		}
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		return array(
			'service'                   => $this->user_service,
			'single_methods'            => array( 'show', 'credit_balance_index', 'token_balance_index', 'token_address_index' ),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
