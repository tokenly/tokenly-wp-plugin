<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;

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
		if ( isset( $params['name'] ) ) {
			$args = array_merge( $args, array(
				'search' => '*'.esc_attr( $params['name'] ).'*',
				'search_columns' => array(
					'user_login',
				),
			) );
		}
		if ( isset( $params['email'] ) ) {
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

	protected function decorate_user( $user ) {
		return $this->user_factory->create( array(
			'user' => $user,
		) );
	}

	protected function decorate_users( $users ) {
		return array_map ( function( $user ) {
			return $this->decorate_user( $user );
		}, $users );
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
