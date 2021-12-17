<?php

namespace Tokenly\Wp\Middleware\Tca;

use Tokenly\Wp\Middleware\Middleware;
use Tokenly\Wp\Interfaces\Middleware\Tca\MenuItemFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Filters the reuslts of navigation menu item queries by checking
 * if the current user can access the post associated with it
 */
class MenuItemFilterMiddleware extends Middleware implements MenuItemFilterMiddlewareInterface {
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
			isset( $this->tca_settings->filter_menu_items ) &&
			$this->tca_settings->filter_menu_items == true
		) {
			add_filter( 'wp_get_nav_menu_items', array( $this, 'run' ), 10, 3 );
		}
	}
	
	/**
	 * Runs the middleware
	 * @param array $item Navigation items
	 * @param object $menu Navigation menu
	 * @param array $args Additional arguments
	 * @return array
	 */
	public function run( array $items, object $menu, array $args ) {
		foreach ( $items as $key => $item ) {
			$post_id = $item->object_id;
			$post = $this->post_service->show( array(
				'id' => $post_id,
			) );
			$can_access = $post->can_access_post( $this->current_user );
			if ( $can_access === false ) {
				unset( $items[ $key ] );
			}
		}
		return $items;
	}
}