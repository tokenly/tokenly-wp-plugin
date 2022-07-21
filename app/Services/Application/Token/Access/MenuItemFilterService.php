<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\MenuItemFilterServiceInterface;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface;

/**
 * Filters the reuslts of navigation menu item queries by checking
 * if the current user can access the post associated with it
 */
class MenuItemFilterService extends Service
	implements MenuItemFilterServiceInterface {
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected TcaSettingsInterface $tca_settings;
	protected PostRepositoryInterface $post_repository;
	protected ?UserInterface $current_user;
	protected UserRepositoryInterface $user_repository;
	protected PostCheckerServiceInterface $post_checker_service;
	
	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		PostRepositoryInterface $post_repository,
		UserRepositoryInterface $user_repository,
		PostCheckerServiceInterface $post_checker_service
	) {
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->post_repository = $post_repository;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->user_repository = $user_repository;
		$this->post_checker_service = $post_checker_service;
	}
	
	/**
	 * @inheritDoc
	 */
	public function register(): void {
		if ( $this->tca_settings->filter_menu_items === true ) {
			add_filter( 'wp_get_nav_menu_items', array( $this, 'run' ),
				10, 3
			);
		}
	}
	
	/**
	 * Runs the Service
	 * @param array $item Navigation items
	 * @param object $menu Navigation menu
	 * @param array $args Additional arguments
	 * @return array
	 */
	public function run( array $items, object $menu, array $args ): array {
		foreach ( $items as $key => $item ) {
			$post_id = $item->object_id;
			$post = $this->post_repository->show( array(
				'id' => $post_id,
			) );
			if ( !$post ) {
				continue;
			}
			$verdict = $this->post_checker_service->check(
				$post,
				$this->current_user
			);
			if ( $verdict->status === false ) {
				unset( $items[ $key ] );
			}
		}
		return $items;
	}
}
