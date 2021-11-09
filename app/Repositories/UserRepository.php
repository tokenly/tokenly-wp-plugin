<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\UserFactoryInterface;

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
		$args = $this->get_base_query_args();
		$name = $params['name'] ?? null;
		if ( $name ) {
			$args = array_merge( $args, $this->get_name_query_args( $name ) );
		}
		$query = new \WP_User_Query( $args );
		$users = $query->get_results();
		$use_suggestions = $params['suggestions'] ?? null;
		if ( $use_suggestions == true ) {
			$suggestions = $this->make_suggestions( $users );
			return $suggestions;
		}
		$users = $this->decorate_users( $users );
		return $users;
	}

	public function show( $params = array() ) {
		$value = $params['id'] ?? null;
		$field;
		if ( $value ) {
			$field = 'id';
			if ( $value == 'me' ) {
				$value = get_current_user_id();
			}
		} elseif ( true ) {
			//
		}
		if ( !$field || !$value ) {
			return;
		}
		$user = get_user_by( $field, $value );
		if ( !$user ) {
			return;
		}
		$user = $this->decorate_user( $user );
		return $user;
	}

	protected function get_base_query_args() {
		return array(
			'orderby'    => 'ID',
			'order'      => 'ASC',
			'meta_query' => array(
				array(
					'key'     => $this->user_meta_repository->namespace_key( 'uuid' ),
					'compare' => 'EXISTS',
				),
			),
		);
	}

	protected function decorate_user( $user ) {
		$user_id = $user->ID;
		$oauth_token = $this->user_meta_repository->show( $user_id, 'oauth_token' );
		if ( !$oauth_token ) {
			return;
		}
		$tokenpass_user = $this->client->getUserByToken( $oauth_token );
		return $this->user_factory->create( array(
			'user'           => $user,
			'tokenpass_user' => $tokenpass_user,
		) );
	}

	protected function decorate_users( $users ) {
		return array_map ( function( $user ) {
			return $this->decorate_user( $user );
		}, $users );
	}

	protected function get_name_query_args( $name ) {
		return array( 
			'search'         => '*'.esc_attr( $name ).'*',
			'search_columns' => array(
				'user_login',
				'user_nicename',
				'user_email',
				'user_url',
			),
		);
	}

	protected function make_suggestions( $users ) {
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
