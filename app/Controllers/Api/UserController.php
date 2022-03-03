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
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;

class UserController extends Controller implements UserControllerInterface {
	protected string $namespace;
	protected UserRepositoryInterface $user_repository;
	protected OauthUserRepositoryInterface $oauth_user_repository;
	protected SourceRepositoryInterface $source_repository;
	protected BalanceRepositoryInterface $balance_repository;

	public function __construct(
		string $namespace,
		UserRepositoryInterface $user_repository,
		OauthUserRepositoryInterface $oauth_user_repository,
		SourceRepositoryInterface $source_repository,
		BalanceRepositoryInterface $balance_repository
	) {
		$this->namespace = $namespace;
		$this->user_repository = $user_repository;
		$this->source_repository = $source_repository;
		$this->oauth_user_repository = $oauth_user_repository;
		$this->balance_repository = $balance_repository;
	}
	
	/**
	 * Gets a collection of users
	 * @param \WP_REST_Request $request Request
	 * @param UserCollectionInterface $users Bound users
	 * @return array
	 */
	public function index( \WP_REST_Request $request, UserCollectionInterface $users ): array {
		if ( $request->get_param( 'suggestions' ) ) {
			$users->to_suggestions();
		}
		$users = $users->to_array();
		return $users;
	}

	/**
	 * Gets a single user
	 * @param \WP_REST_Request $request Request
	 * @param UserInterface|null $user Bound user
	 * @return array|null
	 */
	public function show( \WP_REST_Request $request, UserInterface $user = null ): ?array {
		if ( $user ) {
			$user = $user->to_array();
		}
		return $user;
	}

	/**
	 * Gets a collection credit of balance
	 * @param \WP_REST_Request $request Request data
	 * @param UserInterface|null $user Bound user
	 * @return array
	 */
	public function credit_balance_index( \WP_REST_Request $request, UserInterface $user = null ): array {
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
	 * @param \WP_REST_Request $request Request data
	 * @param UserInterface|null $user Bound user
	 * @return float
	 */
	public function credit_balance_show( \WP_REST_Request $request, UserInterface $user = null ): float {
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
	 * @param \WP_REST_Request $request Request data
	 * @param UserInterface|null $user Bound user
	 * @return array
	 */
	public function token_balance_index( \WP_REST_Request $request, UserInterface $user = null ): array {
		$balance = $this->user_repository->token_balance_index( $user );
		$balance = $balance->to_array();
		return $balance;
	}

	/**
	 * Gets a single balance
	 * @param \WP_REST_Request $request Request data
	 * @param UserInterface|null $user Bound user
	 * @return array
	 */
	public function token_balance_show( \WP_REST_Request $request, UserInterface $user = null ): array {
		$asset = $request->get_param( 'asset' );
		if ( $asset && $user ) {
			
		}
		$balance = $this->user_repository->token_balance_show( $user );
		$balance = $balance->to_array();
		return $balance;
	}

	/**
	 * Gets a collection of addresses
	 * @param \WP_REST_Request $request Request data
	 * @param UserInterface|null $user Bound user
	 * @return array
	 */
	public function token_address_index( \WP_REST_Request $request, UserInterface $user = null ): array {
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
