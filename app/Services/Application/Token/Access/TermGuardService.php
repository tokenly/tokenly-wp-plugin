<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermGuardServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermCheckerServiceInterface;
use Tokenly\Wp\Services\Application\Token\Access\ViewGuardService;
use Tokenly\Wp\Interfaces\Services\Application\ViewRendererInterface;

/**
 * Prevents access to a term page if the TCA check was not passed
 */
class TermGuardService extends ViewGuardService implements TermGuardServiceInterface {
	protected string $type = 'term';
	
	public function __construct(
		string $namespace,
		UserRepositoryInterface $user_repository,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model,
		TermCheckerServiceInterface $term_checker_service,
		ViewRendererInterface $view_renderer
	) {
		parent::__construct(
			$namespace,
			$user_repository,
			$post_access_denied_view_model,
			$term_checker_service,
			$view_renderer
		);
	}
}
