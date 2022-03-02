<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;

use Tokenly\Wp\Interfaces\Services\Application\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\MenuItemFilterServiceInterface as TokenAccessMenuItemFilterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostResultsFilterServiceInterface as TokenAccessPostResultsFilterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostGuardServiceInterface as TokenAccessPostGuardServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermGuardServiceInterface as TokenAccessTermGuardServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Registers general plugin modules
 */
class AppServiceProvider extends ServiceProvider implements AppServiceProviderInterface {
	protected string $namespace;
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		string $namespace,
		AuthServiceInterface $auth_service,
		LifecycleServiceInterface $lifecycle_service,
		ResourceServiceInterface $resource_service,
		QueryServiceInterface $query_service,
		TokenAccessMenuItemFilterServiceInterface $token_access_menu_item_filter_service,
		TokenAccessPostResultsFilterServiceInterface $token_access_post_results_filter_service,
		TokenAccessPostGuardServiceInterface $token_access_post_guard_service,
		TokenAccessTermGuardServiceInterface $token_access_term_guard_service,
		UserRepositoryInterface $user_repository
	) {
		$this->namespace = $namespace;
		$this->user_repository = $user_repository;
		$this->services = array(
			'auth'                             => $auth_service,
			'lifecycle'                        => $lifecycle_service,
			'resource'                         => $resource_service,
			'query'                            => $query_service,
			'token_access_menu_item_filter'    => $token_access_menu_item_filter_service,
			'token_access_post_results_filter' => $token_access_post_results_filter_service,
			'token_access_post_guard'          => $token_access_post_guard_service,
			'token_access_term_guard'          => $token_access_term_guard_service,
		);
		$this->register_hooks();
	}

	protected function register_hooks() {
		$this->register_show_user_profile_hook();
		$this->register_user_row_actions_hook();
	}

	protected function register_show_user_profile_hook(): void {
		add_action( 'show_user_profile', function( \WP_User $user ) {
			$user = $this->user_repository->complete( $user );
			do_action( "{$this->namespace}_show_user_profile", $user );
		}, 10, 1 );
	}

	protected function register_user_row_actions_hook(): void {
		add_filter( "user_row_actions", function( array $actions, \WP_User $user ) {
			$user = $this->user_repository->complete( $user );
			$actions = apply_filters( "{$this->namespace}_user_row_actions", $actions, $user );
			return $actions;
		}, 10, 2 );
	}
}
