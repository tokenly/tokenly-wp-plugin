<?php

namespace Tokenly\Wp\Repositories;

class UserRepository {
	public function index( $index_parameters ) {
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
}
