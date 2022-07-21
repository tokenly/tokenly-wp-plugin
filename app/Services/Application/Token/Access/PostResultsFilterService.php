<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostResultsFilterServiceInterface;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;

/**
 * Filters the results of post queries by checking
 * if the current user can access them
 */
class PostResultsFilterService extends Service implements PostResultsFilterServiceInterface {
	protected string $namespace;
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected TcaSettingsInterface $tca_settings;
	protected PostRepositoryInterface $post_repository;
	protected ?UserInterface $current_user;
	protected UserRepositoryInterface $user_repository;
	protected PostCheckerServiceInterface $post_checker_service;
	
	public function __construct(
		string $namespace,
		TcaSettingsRepositoryInterface $tca_settings_repository,
		PostRepositoryInterface $post_repository,
		UserRepositoryInterface $user_repository,
		PostCheckerServiceInterface $post_checker_service
	) {
		$this->namespace = $namespace;
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->post_repository = $post_repository;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->post_checker_service = $post_checker_service;
	}
	
	/**
	 * @inheritDoc
	 */
	public function register(): void {
		if ( $this->tca_settings->filter_post_results === true ) {
			add_filter(
				"{$this->namespace}_posts_results",
				array( $this, 'filter' ), 10, 2
			);
		}
	}
	
	/**
	 * Runs the Service
	 * @param array $posts
	 * @param array $query Query data
	 * @return array
	 */
	public function filter( PostCollectionInterface $posts, $query ): array {
		$current_post_id = 0;
		$is_singular = $query->is_singular;
		if ( $is_singular == true && isset( $query->posts[0] )) {
			$post = $query->posts[0];
			$current_post_id = $post->ID;
		}
		foreach ( ( array ) $posts as $key => $post ) {
			if ( $current_post_id == $post->ID ) {
				continue;
			}
			$verdict = $this->post_checker_service->check(
				$post,
				$this->current_user
			);
			if ( $verdict->status === false ) {
				unset( $posts[ $key ] );
			}
		}
		$posts = $posts->extract( 'post' );
		return $posts;
	}
}
