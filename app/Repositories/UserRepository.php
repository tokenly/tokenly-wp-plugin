<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;

class UserRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client
	) {
		$this->client = $client;
	}

	public function index( $params ) {
		$name = $params['name'] ?? null;
		$args = array(
			'orderby' => 'ID',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'tokenly_uuid',
					'compare' => 'EXISTS',
				)
			)
		);
		if ( $name ) {
			$args = array_merge( $args, array( 
				'search'         => '*'.esc_attr( $name ).'*',
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'user_email',
					'user_url',
				),
			) );
		}
		$wp_user_query = new \WP_User_Query( $args );
		$users = $wp_user_query->get_results();
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

	public function show( $user_id ) {
		$oauth_token = get_user_meta( $user_id, $key = 'tokenly_oauth_token' );
		if ( !$oauth_token ) {
			return;
		}
		$user = $this->client->getUserByToken( $oauth_token[0] );
		return $user;
	}
}
