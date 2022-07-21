<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

use Tokenly\Wp\Collections\UserCollection;
use Tokenly\Wp\Collections\Token\PromiseMetaCollection;
use Tokenly\Wp\Models\User;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface 
	as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface 
	as TokenBalanceInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface 
	as CreditAccountInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface 
	as CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Manages users
 */
class UserRepository extends Repository implements UserRepositoryInterface {
	protected TokenpassAPIInterface $client;
	protected UserMetaRepositoryInterface $user_meta_repository;
	protected OauthUserRepositoryInterface $oauth_user_repository;
	protected BalanceRepositoryInterface $balance_repository;
	protected SourceRepositoryInterface $source_repository;
	protected AddressRepositoryInterface $address_repository;
	protected CreditAccountRepositoryInterface $credit_account_repository;
	protected string $namespace;
	protected array $meta;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		OauthUserRepositoryInterface $oauth_user_repository,
		BalanceRepositoryInterface $balance_repository,
		SourceRepositoryInterface $source_repository,
		AddressRepositoryInterface $address_repository,
		CreditAccountRepositoryInterface $credit_account_repository,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->oauth_user_repository = $oauth_user_repository;
		$this->meta = $this->get_meta_fields();
		$this->balance_repository = $balance_repository;
		$this->source_repository = $source_repository;
		$this->address_repository = $address_repository;
		$this->credit_account_repository = $credit_account_repository;
	}

	/**
	 * Gets a collection of users
	 * @param array $params Search parameters
	 * @return UserCollectionInterface Users found
	 */
	public function index( array $params = array() ): UserCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single user
	 * @param array $params Search parameters
	 * @return UserInterface|null User found
	 */
	public function show( array $params = array() ): ?UserInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets the current user
	 * @param array $params Additional parameters
	 * @return UserInterface|null Current user
	 */
	public function show_current( array $params = array() ): ?UserInterface {
		$id = get_current_user_id();
		if ( $id == 0 ) {
			return null;
		}
		$params['id'] = $id;
		$user = $this->show( $params );
		return $user;
	}

	/**
	 * Makes a new WordPress user using OAuth user data
	 * @param OauthUserInterface $oauth_user Reference user
	 * @return UserInterface|null New user
	 */
	public function store( OauthUserInterface $oauth_user ): ?UserInterface {
		$username = $oauth_user->get_username();
		$password = wp_generate_password( 12, false );
		$email = $oauth_user->get_email() ?? null;
		$user_id = wp_create_user( $username, $password, $email );
		if ( is_numeric( $user_id ) === false ) {
			return null;
		}
		$user = $this->show( array(
			'id' => $user_id,
		) );
		return $user;
	}

	public function update( UserInterface $user, array $params ) {
		$params = $this->filter_meta_params( $params );
		$this->user_meta_repository->update( $user->ID, $params );
	}

	/**
	 * Decorates a single User
	 * @param \WP_User $user User to decorate
	 * @return UserInterface|null
	 */
	public function complete( \WP_User $user ): ?UserInterface {
		$user = $this->append_meta( $user );
		$user = ( new User() )->from_array( $user );
		return $user;
	}

	/**
	 * Decorates a collection of Users
	 * @param \WP_User[] $users Users to decorate
	 * @return UserCollectionInterface
	 */
	public function complete_collection(
		array $users = array()
	): TermCollectionInterface {
		$users = $this->append_meta_collection( $users );
		$users = ( new UserCollection() )->from_array( $users );
		return $users;
	}

	public function get_promise_users( $promises ): UserCollectionInterface {
		$promises = $this->promise_repository->load(
			$promises, array( 'promise_meta' ) );
		$promise_meta = clone $promises;
		$promise_meta = $promises->extract( 'promise_meta' );
		$promise_meta = new PromiseMetaCollection( $promise_meta );
		$source_users = clone $promise_meta;
		$source_users = $source_users->extract( 'source_user_id' );
		$destination_users = clone $promise_meta;
		$destination_users = $destination_users->extract( 'destination_user_id' );
		$users = array_merge( $source_users, $destination_users );
		return $this->index( array(
			'uuids' => $users,
		) );
	}

	public function credit_balance_index(
		UserInterface $user
	): ?CreditAccountCollectionInterface {
		$this->load( $user, array( 'oauth_user.credit_account' ) );
		$account;
		if (
			$user->oauth_user &&
			$user->oauth_user->credit_account
		) {
			$account = $user->oauth_user->credit_account;
		} else {
			$account = null;
		}
		return $account;
	}

	/**
	 * Gets a single credit balance
	 * @param UserInterface $user Target User
	 * @param string $group_id Target group
	 * @return CreditAccountInterface|null
	 */
	public function credit_balance_show(
		UserInterface $user,
		string $group_id
	): ?CreditAccountInterface {
		$account = $this->credit_account_repository->show( array(
			'group_uuid'   => $group_id,
			'account_uuid' => $user->uuid,
		) );
		return $account;
	}

	public function token_balance_index(
		UserInterface $user,
		array $params = array()
	): ?BalanceCollectionInterface {
		$balance = $this->balance_repository->index( array(
			'oauth_token' => $user->oauth_token,
			'with'        => array( 'meta' ),
		) );
		return $balance;
	}

	/**
	 * Gets the balance for the specified token
	 * @param string $asset Asset to get balance for
	 * @return TokenBalanceInterface|null
	 */
	public function token_balance_show(
		UserInterface $user,
		string $asset
	): ?TokenBalanceInterface {
		$balance = $this->token_balance_index( $user );
		$balance = clone $balance;
		$balance->key_by_asset_name();
		if ( isset( $balance[ $asset ] ) ) {
			$balance = $balance[ $asset ];
		} else {
			$balance = null;
		}
		return $balance;
	}

	public function token_address_index(
		UserInterface $user,
		array $params
	): AddressCollectionInterface {
		$addresses = $this->address_repository->index( array(
			'oauth_token' => $user->oauth_token,
		) );
		if ( isset( $params['registered'] ) ) {
			$sources = $this->source_repository->index();
			$addresses = clone $addresses;
			$addresses->filter_registered( $sources );
		}
		return $addresses;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return UserCollectionInterface
	 */
	protected function index_cacheable(
		array $params = array()
	): UserCollectionInterface {
		$users = array();
		$args = $this->get_query_args( $params );
		if ( $args && is_array( $args ) ) {
			$users_found = $this->query( $args );
			if ( $users_found && is_array( $users_found ) ) {
				$users = $this->append_meta_collection( $users_found );
			}
		}
		$users = ( new UserCollection() )->from_array( $users );
		return $users;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return UserInterface|null
	 */
	protected function show_cacheable( array $params = array() ): ?UserInterface {
		if ( isset( $params['id'] ) && $params['id'] == 'me' ) {
			unset( $params['id'] );
			$user = $this->show_current( $params );
		} else {
			$params['number'] = 1;
			$args = $this->get_query_args( $params );
			$users = $this->query( $args );
			if ( !isset( $users[0] ) ) {
				return null;
			}
			$user = $users[0];
			$user = $this->append_meta( $user );
			$user = ( new User() )->from_array( $user );
		}
		return $user;
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields(): array {
		return array(
			'uuid',
			'oauth_token',
			'can_connect',
		);
	}

	/**
	 * Filters the specified array accoring to the meta property
	 * @param array $params Array to filter
	 * @return array
	 */
	protected function filter_meta_params( array $params = array() ): array {
		foreach ( $params as $key => $param ) {
			if ( !in_array( $key, $this->meta ) ) {
				unset( $params[ $key ] );
			}
		}
		return $params;
	}
	
	/**
	 * Gets the query arguments for the Show and Index methods
	 * @param array $params Search parameters
	 * @return array
	 */
	protected function get_query_args( array $params = array() ): array {
		$args = array(
			'orderby'    => 'ID',
			'order'      => 'ASC',
			'meta_query' => array(),
		);
		if ( isset( $params['number'] ) ) {
			$args['number'] = $params['number'];
		}
		if ( isset( $params['uuid'] ) ) {
			$args['meta_query'][] = array(
				'key'     => "{$this->namespace}_uuid",
				'value'   => $params['uuid'],
				'compare' => '=',
			);
		}
		elseif ( isset( $params['uuids'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => "{$this->namespace}_uuid",
				'value'   => $params['uuids'] ?? null,
				'compare' => 'IN',
			);
		}
		else if ( isset( $params['id'] ) ) {
			$args = array_merge( $args, array(
				'search'         => $params['id'],
				'search_columns' => array( 'ID' )
			) );
		}
		else if ( isset( $params['name'] ) ) {
			$args = array_merge( $args, array(
				'search' => '*'.esc_attr( $params['name'] ).'*',
				'search_columns' => array(
					'user_login',
				),
			) );
		}
		else if ( isset( $params['email'] ) ) {
			$args = array_merge( $args, array(
				'search' => '*'.esc_attr( $params['email'] ).'*',
				'search_columns' => array(
					'user_email',
				),
			) );
		}
		return $args;
	}

	/**
	 * Gets the arguments for the Store method
	 * @param array $params Store parameters
	 * @return array $args
	 */
	protected function get_store_args( array $params = array() ): array {
		$args = array(
			'post_type'  => $this->post_type,
		);
		return $args;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_User $user User to target
	 * @return array
	 */
	protected function append_meta( \WP_User $user ): array {
		$meta = $this->load_meta( $user );
		$user = array_merge( array(
			'user' => $user,
		), $meta );
		return $user;
	}

	/**
	 * Loads the meta for a collection of users
	 * @param array $users Users to target
	 * @return array
	 */
	protected function append_meta_collection( array $users ): array {
		foreach ( $users as &$user ) {
			$user = $this->append_meta( $user );
		}
		return $users;
	}

	/**
	 * Searches for users using the specified arguments
	 * @param array $args Search arguments
	 * @return array
	 */
	protected function query( array $args = array() ): array {
		$query = new \WP_User_Query( $args );
		$users = $query->get_results();
		return $users;
	}

	/**
	 * Gets the meta fields associated with the user
	 * after retrieving the user
	 * @param \WP_User $user User to target
	 * @return array
	 */
	protected function load_meta( \WP_User $user ): array {
		$meta = $this->user_meta_repository->index( $user->ID, ...$this->meta );
		return $meta;
	}

	/**
	 * Loads the oauth_user relation
	 * @param UserInterface $user Target User
	 * @param string[] $relations Further relations
	 * @return OauthUserInterface|null
	 */
	protected function load_oauth_user( UserInterface $user, array $relations = array() ): ?OauthUserInterface {
		$oauth_user = $this->oauth_user_repository->show(
			array(
				'id'   => $user->ID,
				'with' => $relations,
			)
		);
		return $oauth_user;
	}
}
