<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Controllers\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface;

use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;

class UserController extends Controller implements UserControllerInterface {
	public function __construct(
		UserRepositoryInterface $user_repository,
		OauthUserRepositoryInterface $oauth_user_repository,
		SourceRepositoryInterface $source_repository
	) {
		$this->user_repository = $user_repository;
		$this->source_repository = $source_repository;
		$this->oauth_user_repository = $oauth_user_repository;
	}
	
	/**
	 * Gets a collection of users
	 * @param UserCollectionInterface $users Bound users
	 * @param \WP_REST_Request $request Request
	 * @return array
	 */
	public function index( UserCollectionInterface $users, \WP_REST_Request $request ): array {
		if ( $request->get_param( 'suggestions' ) ) {
			$users->to_suggestions();
		}
		$users = $users->to_array();
		return $users;
	}

	/**
	 * Gets a single user
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request
	 * @return array|null
	 */
	public function show( UserInterface $user = null, \WP_REST_Request $request ): ?array {
		if ( $user ) {
			$user = $user->to_array();
		}
		return $user;
	}

	/**
	 * Gets a collection credit of balance
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function credit_balance_index( UserInterface $user = null, \WP_REST_Request $request ): array {
		$account = array();
		if ( $user ) {
			$this->user_repository->load( $user, array( 'oauth_user.credit_account' ) );
			if (
				$user->get_oauth_user() &&
				$user->get_oauth_user()->get_credit_account()
			) {
				$account = $user->get_oauth_user()->get_credit_account()->to_array();
			}
		}
		return $account;
	}

	/**
	 * Gets a single credit balance
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return float
	 */
	public function credit_balance_show( UserInterface $user = null, \WP_REST_Request $request ): float {
		$balance = 0;
		if ( $user ) {
			$this->user_repository->load( $user, array( 'oauth_user' ) );
			if ( $user->get_oauth_user() ) {
				$group = $request->get_param( 'group' );
				$account = $this->oauth_user_repository->credit_balance_show( $user->get_oauth_user(), $group );
				if ( $account ) {
					$balance = $account->get_balance();
				}
			}
		}
		return $balance;
	}

	/**
	 * Gets a collection of token balance
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function token_balance_index( UserInterface $user = null, \WP_REST_Request $request ): array {
		$balance = array();
		if ( $user ) {
			$this->user_repository->load( $user, array( 'oauth_user.balance.meta' ) );
			if ( !$user->get_oauth_user() || $user->get_oauth_user() instanceof OauthUserInterface === false ) {
				return array();
			}
			if ( !$user->get_oauth_user()->get_balance() || $user->get_oauth_user()->get_balance() instanceof BalanceCollectionInterface === false ) {
				return array();
			}
			$balance = $user->get_oauth_user()->get_balance()->to_array();
		}

		return $balance;
	}

	/**
	 * Gets a single balance
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function token_balance_show( UserInterface $user = null, \WP_REST_Request $request ): array {
		$balance = array();
		if ( $user ) {
			$this->user_repository->load( $user, array( 'oauth_user.balance' ) );
			if ( !$user->get_oauth_user() || $user->get_oauth_user() instanceof OauthUserInterface === false ) {
				return array();
			}
			if ( !$user->get_oauth_user()->get_balance() || $user->get_oauth_user()->get_balance() instanceof BalanceCollectionInterface === false ) {
				return array();
			}
			$balance_collection = clone $user->get_oauth_user()->get_balance();
			$balance_collection->key_by_asset_name();
			$asset = $request->get_param( 'asset' );
			if ( isset( $balance_collection[ $asset ] ) ) {
				$balance = $balance_collection[ $asset ];
				$balance = $balance->to_array();
			}
		}
		return $balance;
	}

	/**
	 * Gets a collection of addresses
	 * @param UserInterface|null $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function token_address_index( UserInterface $user = null, \WP_REST_Request $request ): array {
		$address = array();
		if ( $user ) {
			$this->user_repository->load( $user, array( 'oauth_user.address' ) );
			if (
				$user->get_oauth_user() &&
				$user->get_oauth_user()->get_address()
			) {
				$address = clone $user->get_oauth_user()->get_address();
				$registered = $request->get_param( 'registered' );
				if ( $registered ) {
					$sources = $this->source_repository->index();
					$address->filter_registered( $sources );
				}
				$address = $address->to_array();
			}
		}
		return $address;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params(): array {
		return array(
			'service'                   => $this->user_repository,
			'single_methods'            => array(
				'show',
				'credit_balance_index',
				'credit_balance_show',
				'token_balance_index',
				'token_balance_show',
				'token_address_index',
			),
			'single_service_method'     => 'show',
			'collection_methods'        => array( 'index' ),
			'collection_service_method' => 'index',
		);
	}
}
