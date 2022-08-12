<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\ViewGuardServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\CheckerServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\ViewRendererInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;

/**
 * Prevents access to post if the TCA check was not passed
 */
class ViewGuardService extends Service implements ViewGuardServiceInterface {
	protected string $namespace;
	protected ?UserInterface $current_user;
	protected UserRepositoryInterface $user_repository;
	protected PostAccessDeniedViewModelInterface $post_access_denied_view_model;
	protected CheckerServiceInterface $checker_service;
    protected string $type;
	protected ViewRendererInterface $view_renderer;
	
	public function __construct(
		string $namespace,
		UserRepositoryInterface $user_repository,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model,
		CheckerServiceInterface $checker_service,
		ViewRendererInterface $view_renderer
	) {
		$this->namespace = $namespace;
		$this->user_repository = $user_repository;
		$this->current_user = $this->user_repository->show_current();
		$this->post_access_denied_view_model = $post_access_denied_view_model;
		$this->checker_service = $checker_service;
		$this->view_renderer = $view_renderer;
	}
	
	/**
	 * @inheritDoc
	 */
	public function register(): void {
		add_action(
			"{$this->namespace}_template_redirect_{$this->type}",
			array( $this, 'check' )
		);
	}
	
	/**
	 * Checks if the current user is able to access the item
	 * @var ProtectableInterface $item Protected item
	 * @return void
	 */
	public function check( ProtectableInterface $item ): void {
		$verdict = $this->checker_service->check(
			$item,
			$this->current_user
		);
		$rules = $this->checker_service->get_tca_rules( $item );
		if ( $verdict->status === false ) {
			if ( is_admin() === true ) {
				wp_die( 'Access Denied - Token Controlled Access.' );
			} else {
				$this->view_renderer->render( function() use ( $verdict, $rules ) {
					$view_data = $this->post_access_denied_view_model->prepare(
						array(
							'verdict' => $verdict,
							'rules'   => $rules,
						)
					);
					return array(
						'template' => 'Denied.twig',
						'data'     => $view_data,
					);
				});
				exit;
			}
		}
	}
}
