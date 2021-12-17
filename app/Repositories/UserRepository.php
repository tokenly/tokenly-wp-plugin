<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;

/**
 * Manages users
 */
class UserRepository implements UserRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $user_factory;
	protected $user_collection_factory;
	protected $namespace;
	protected $meta;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		UserFactoryInterface $user_factory,
		UserCollectionFactoryInterface $user_collection_factory,
		string $namespace
	) {
		$this->namespace = $namespace;
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->user_factory = $user_factory;
		$this->user_collection_factory = $user_collection_factory;
		$this->meta = $this->get_meta_fields();
	}

	/**
	 * Retrieves a collection of users
	 * @param array $params Search paramters
	 * @return UserCollectionInterface
	 */
	public function index( array $params = array() ) {
		$args = $this->get_query_args( $params );
		$users = $this->query( $args );
		$users = $this->append_meta_collection( $users );
		$users = $this->user_collection_factory->create( $users );
		return $users;
	}

	/**
	 * Retrieves a single user
	 * @param integer $params User search params
	 * @return object
	 */
	public function show( array $params = array() ) {
		$params['number'] = 1;
		$args = $this->get_query_args( $params );
		$users = $this->query( $args );
		if ( !isset( $users[0] ) ) {
			return;
		}
		$user = $users[0];
		$user = $this->append_meta( $user );
		$user = $this->user_factory->create( $user );
		return $user;
	}

	/**
	 * Creates a new WordPress user
	 * @param string $username New user name
	 * @param string $password New user password
	 * @param string $email New user email
	 * @return UserInterface New user
	 */
	public function store( string $username, string $password, string $email ) {
		$user_id = wp_create_user( $username, $password, $email );
		if ( is_numeric( $user_id ) === false ) {
			return false;
		}
		$user = $this->show( array(
			'id' => $user_id,
		) );
		return $user;
	}
	
	/**
	 * Updates the specific user
	 * @param object $user Target user
	 * @param array $params Update parameters
	 * @return object
	 */
	public function update( UserInterface $user, array $params ) {
		$params = $this->filter_meta_params( $params );
		$this->user_meta_repository->update( $user->ID, $params );
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields() {
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
	protected function filter_meta_params( array $params = array() ) {
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
	protected function get_query_args( array $params = array() ) {
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
	protected function get_store_args( array $params = array() ) {
		$args = array(
			'post_type'  => $this->post_type,
		);
		return $args;
	}

	/**
	 * Searches for users using the specified arguments
	 * @param array $args Search arguments
	 * @return array
	 */
	protected function query( array $args = array() ) {
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
	protected function load_meta( \WP_User $user ) {
		$meta = $this->user_meta_repository->index( $user->ID, ...$this->meta );
		return $meta;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_User $user User to target
	 * @return array
	 */
	protected function append_meta( \WP_User $user ) {
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
	protected function append_meta_collection( array $users ) {
		foreach ( $users as &$user ) {
			$user = $this->append_meta( $user );
		}
		return $users;
	}
}
