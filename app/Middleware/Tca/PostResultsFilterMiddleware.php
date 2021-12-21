<?php

namespace Tokenly\Wp\Middleware\Tca;

use Tokenly\Wp\Middleware\Middleware;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostResultsFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Filters the results of post queries by checking
 * if the current user can access them
 */
class PostResultsFilterMiddleware implements PostResultsFilterMiddlewareInterface {
	protected $tca_settings;
	protected $post_service;
	protected $current_user;
	
	public function __construct(
		TcaSettingsInterface $tca_settings,
		PostServiceInterface $post_service,
		CurrentUserInterface $current_user
	) {
		$this->tca_settings = $tca_settings;
		$this->post_service = $post_service;
		$this->current_user = $current_user;
	}
	
	/**
	 * Registers the middleware
	 */
	public function register() {
		if (
			isset( $this->tca_settings->filter_post_results ) &&
			$this->tca_settings->filter_post_results == true
		) {
			add_filter( 'posts_results', array( $this, 'run' ), 10, 3 );
		}
	}
	
	/**
	 * Runs the middleware
	 * @param array $posts
	 * @return array
	 */
	public function run( array $posts, $query ) {
		$posts_decorated = $this->post_service->complete_collection( $posts );
		$current_post_id = 0;
		$is_singular = $query->is_singular;
		if ( $is_singular == true && isset( $query->posts[0] )) {
			$post = $query->posts[0];
			$current_post_id = $post->ID;
		}
		foreach ( (array) $posts_decorated as $key => $post ) {
			if ( $current_post_id == $post->ID ) {
				continue;
			}
			$can_access = $post->can_access( $this->current_user );
			if ( $can_access == false ) {
				unset( $posts[ $key ] );
			}
		}
		return $posts;
	}
}
