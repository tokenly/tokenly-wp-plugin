<?php

namespace Tokenly\Wp\Middleware\Tca;

use Tokenly\Wp\Middleware\Middleware;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostGuardMiddlewareInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

/**
 * Prevents access to post if the TCA check was not passed
 */
class PostGuardMiddleware extends Middleware implements PostGuardMiddlewareInterface {
	protected $post_service;
	protected $namespace;
	protected $current_user;
	protected $user_service;
	protected $twig;
	protected $post_access_denied_view_model;
	
	public function __construct(
		PostServiceInterface $post_service,
		string $namespace,
		UserServiceInterface $user_service,
		Environment $twig,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model
	) {
		$this->post_service = $post_service;
		$this->namespace = $namespace;
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
		$this->twig = $twig;
		$this->post_access_denied_view_model = $post_access_denied_view_model;
	}
	
	/**
	 * Registers the middleware
	 */
	public function register() {
		add_action( 'template_redirect', array( $this, 'run' ) );
	}
	
	/**
	 * Runs the middleware
	 * @return void
	 */
	public function run() {
		$queried_object = get_queried_object();
		if ( !$queried_object || $queried_object instanceof \WP_Post === false ) {
			return;
		}
		$post_id = $queried_object->ID;
		$post = $this->post_service->show( array(
			'id' => $post_id,
		) );
		if ( !$post ) {
			return;
		}
		$verdict = $post->can_access( $this->current_user );
		$rules = $post->get_tca_rules();
		if ( $verdict->status === false ) {
			if ( is_admin() === true ) {
				wp_die( 'Access denied by TCA.' );
			} else {
				$view_data = $this->post_access_denied_view_model->prepare( array(
					'verdict' => $verdict,
					'rules'   => $rules,
				) );
				echo $this->twig->render( 'Denied.twig', $view_data );
				exit;
			}
		}
	}
}
