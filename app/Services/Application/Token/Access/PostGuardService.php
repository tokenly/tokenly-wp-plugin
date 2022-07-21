<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostGuardServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Prevents access to post if the TCA check was not passed
 */
class PostGuardService extends Service implements PostGuardServiceInterface {
	protected string $namespace;
	protected ?UserInterface $current_user;
	protected UserRepositoryInterface $user_repository;
	protected Environment $twig;
	protected PostAccessDeniedViewModelInterface $post_access_denied_view_model;
	protected PostCheckerServiceInterface $post_checker_service;
	
	public function __construct(
		string $namespace,
		UserRepositoryInterface $user_repository,
		Environment $twig,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model,
		PostCheckerServiceInterface $post_checker_service
	) {
		$this->namespace = $namespace;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->twig = $twig;
		$this->post_access_denied_view_model = $post_access_denied_view_model;
		$this->post_checker_service = $post_checker_service;
	}
	
	/**
	 * @inheritDoc
	 */
	public function register(): void {
		add_action(
			"{$this->namespace}_template_redirect_post",
			array( $this, 'check' )
		);
	}
	
	/**
	 * @inheritDoc
	 */
	public function check( PostInterface $post ): void {
		$verdict = $this->post_checker_service->check(
			$post,
			$this->current_user
		);
		$rules = $this->post_checker_service->get_tca_rules( $post );
		if ( $verdict->status === false ) {
			if ( is_admin() === true ) {
				wp_die( 'Access Denied - Token Controlled Access.' );
			} else {
				$view_data = $this->post_access_denied_view_model->prepare(
					array(
						'verdict' => $verdict,
						'rules'   => $rules,
					)
				);
				echo $this->twig->render( 'Denied.twig', $view_data );
				exit;
			}
		}
	}
}
