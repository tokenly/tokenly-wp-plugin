<?php

namespace Tokenly\Wp\Middleware\Tca;

use Tokenly\Wp\Middleware\Middleware;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostGuardMiddlewareInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Twig\Environment;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

/**
 * Prevents access to post if the TCA check was not passed
 */
class PostGuardMiddleware extends Middleware implements PostGuardMiddlewareInterface {
	protected $post_service;
	protected $namespace;
	protected $current_user;
	protected $twig;
	protected $post_access_denied_view_model;
	
	public function __construct(
		PostServiceInterface $post_service,
		string $namespace,
		CurrentUserInterface $current_user,
		Environment $twig,
		PostAccessDeniedViewModelInterface $post_access_denied_view_model
	) {
		$this->post_service = $post_service;
		$this->namespace = $namespace;
		$this->current_user = $current_user;
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
		$is_virtual = boolval( get_query_var( "{$this->namespace}_virtual" ) ) ?? false;
		if ( $is_virtual === true ) {
			return;
		}
		$post_id = get_the_ID();
		$post = $this->post_service->show( array(
			'id' => $post_id,
		) );
		if ( !$post ) {
			return;
		}
		$can_access = $post->can_access_post( $this->current_user );
		if ( $can_access === false ) {
			if ( is_admin() === true ) {
				wp_die( 'Access denied by TCA.' );
			} else {
				$view_data = $this->post_access_denied_view_model->prepare();
				echo $this->twig->render( 'Denied.twig', $view_data );
				exit;
			}
		}
	}
}