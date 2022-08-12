<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Application\Token\Access\ViewGuardService;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostGuardServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\ViewRendererInterface;

/**
 * Prevents access to a post if the TCA check was not passed
 */
class PostGuardService extends ViewGuardService implements PostGuardServiceInterface {
	protected string $type = 'post';
	
	public function __construct(
		string $namespace,
		UserRepositoryInterface $user_repository,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model,
		PostCheckerServiceInterface $post_checker_service,
		ViewRendererInterface $view_renderer
	) {
		parent::__construct(
			$namespace,
			$user_repository,
			$post_access_denied_view_model,
			$post_checker_service,
			$view_renderer
		);
	}
}
