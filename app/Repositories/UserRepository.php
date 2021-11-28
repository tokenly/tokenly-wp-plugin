<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class UserRepository implements UserRepositoryInterface {
	protected $client;
	protected $user_meta_repository;
	protected $user_factory;
	protected $user_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserMetaRepositoryInterface $user_meta_repository,
		UserFactoryInterface $user_factory,
		UserCollectionFactoryInterface $user_collection_factory
	) {
		$this->client = $client;
		$this->user_meta_repository = $user_meta_repository;
		$this->user_factory = $user_factory;
		$this->user_collection_factory = $user_collection_factory;
	}

	public function index( array $params = array() ) {
		$args = array(
			'orderby'    => 'ID',
			'order'      => 'ASC',
			'meta_query' => array(),
		);
		if ( isset( $params['uuid'] ) ) {
			$args['meta_query'][] = array(
				'key'     => $this->user_meta_repository->namespace_key( 'uuid' ),
				'value'   => $params['uuid'],
				'compare' => '=',
			);
		}
		elseif ( isset( $params['uuids'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => $this->user_meta_repository->namespace_key( 'uuid' ),
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
		$query = new \WP_User_Query( $args );
		$users = $query->get_results();
		$users = $this->user_collection_factory->create( $users );
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
	public function store( $username, $password, $email ) {
		$user_id = wp_create_user( $username, $password, $email );
		if ( is_numeric( $user_id ) === false ) {
			return false;
		}
		$user = get_user_by( 'ID', $user_id );
		if ( !$user ) {
			return;
		}
		$user = $this->user_factory->create( $user );
		return $user;
	}
}
