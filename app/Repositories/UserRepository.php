<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class UserRepository implements UserRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $user_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		UserFactoryInterface $user_factory
	) {
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->user_factory = $user_factory;
	}

	public function index( $params ) {
		$args = array(
			'orderby'    => 'ID',
			'order'      => 'ASC',
			'meta_query' => array(),
		);
		if ( isset( $params['uuid'] ) ) {
			$args['meta_query'][] = array(
				'key'     => $this->user_meta_repository->namespace_key( 'uuid' ),
				'compare' => 'EXISTS',
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
		$query = new \WP_User_Query( $args );
		$users = $query->get_results();
		if ( isset( $params['suggestions'] ) ) {
			$suggestions = $this->make_suggestions( $users );
			return $suggestions;
		}
		$users = $this->decorate_users( $users );
		return $users;
	}

	public function show( $params ) {
		$users = $this->index( $params );
		return $users[0] ?? null;
	}

	/**
	 * Generates a new WordPress user using Tokenpass data
	 * @param OauthUserInterface $oauth_user Reference user
	 * @return UserInterface New user
	 */
	public function store( OauthUserInterface $oauth_user ) {
		$username = $oauth_user->username;
		$password = wp_generate_password( 12, false );
		$email = $tokenpass_user->email ?? null;
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
	 * Applies UserInterface decorator to a WP_User instance
	 * @param \WP_User $user WordPress user
	 * @return UserInterface Decorated user
	 */
	protected function decorate_user( \WP_User $user ) {
		return $this->user_factory->create( array(
			'user' => $user,
		) );
	}

	/**
	 * Applies UserInterface decorator to WP_User instances
	 * @param \WP_User[] $users WordPress users
	 * @return UserInterface[] Decorated users
	 */
	protected function decorate_users( array $users ) {
		return array_map ( function( $user ) {
			return $this->decorate_user( $user );
		}, $users );
	}

	/**
	 * Creates an array of suggestions out of users
	 * (used for real-time search in combobox inputs)
	 * @param \WP_User[] $users
	 * @return array Suggestions
	 */
	protected function make_suggestions( array $users ) {
		$suggestions = array();
		if ( !empty( $users ) ) {
			foreach ( $users as $user ) {
				$suggestions[] = array(
					'id'   => $user->ID, 
					'name' => $user->nickname,
				);
			}
		}
		return $suggestions;
	}
}
