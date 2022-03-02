<?php

namespace Tokenly\Wp\Services\Application;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\ResourceServiceInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\ApiRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\AdminRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\PostRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\TermRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\WebRouteRepositoryInterface;

/**
 * Manages resources
 */
class ResourceService extends Service implements ResourceServiceInterface {
	protected string $root_url;
	protected string $root_dir;
	protected string $build_url;
	protected string $namespace;
	protected string $fallback_image;
	protected UserRepositoryInterface $user_repository;
	protected IntegrationSettingsRepositoryInterface $integration_settings_repository;
	protected IntegrationSettingsInterface $integration_settings;
	protected ApiRouteRepositoryInterface $api_route_repository;
	protected AdminRouteRepositoryInterface $admin_route_repository;
	protected PostRouteRepositoryInterface $post_route_repository;
	protected TermRouteRepositoryInterface $term_route_repository;
	protected WebRouteRepositoryInterface $web_route_repository;

	public function __construct(
		string $root_url,
		string $root_dir,
		string $namespace,
		string $fallback_image,
		UserRepositoryInterface $user_repository,
		IntegrationSettingsRepositoryInterface $integration_settings_repository,
		ApiRouteRepositoryInterface $api_route_repository,
		AdminRouteRepositoryInterface $admin_route_repository,
		PostRouteRepositoryInterface $post_route_repository,
		TermRouteRepositoryInterface $term_route_repository,
		WebRouteRepositoryInterface $web_route_repository
	) {
		$this->root_url = $root_url;
		$this->root_dir = $root_dir;
		$this->build_url = "{$this->root_url}/build";
		$this->namespace = $namespace;
		$this->fallback_image = $fallback_image;
		$this->user_repository = $user_repository;
		$this->integration_settings_repository = $integration_settings_repository;
		$this->api_route_repository = $api_route_repository;
		$this->admin_route_repository = $admin_route_repository;
		$this->post_route_repository = $post_route_repository;
		$this->term_route_repository = $term_route_repository;
		$this->web_route_repository = $web_route_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_filter( "{$this->namespace}_shared_data", array( $this, 'append_shared_data' ) );
	}

	/**
	 * Embeds scripts and styles on frontend routes
	 * @wp-hook wp_enqueue_scripts
	 * @return void
	 */
	public function enqueue_frontend_scripts(): void {
		$version = $this->get_version_for_build( 'Frontend' );
		$label = "{$this->namespace}-frontend";
		wp_register_script( $label, "{$this->build_url}/Frontend.js", array( 'wp-element' ), $version, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Frontend.css", $version );
		wp_enqueue_style( $label );
		$this->enqueue_shared_script();
	}

	/**
	 * Embeds scripts and styles on admin routes
	 * @wp-hook login_enqueue_scripts
	 * @wp-hook admin_enqueue_scripts
	 * @return void
	 */
	public function enqueue_admin_scripts(): void {
		wp_enqueue_media();
		$version = $this->get_version_for_build( 'Admin' );
		$label = "{$this->namespace}-admin";
		wp_register_script( $label, "{$this->build_url}/Admin.js", array( 'wp-components', 'wp-element' ), $version, true );
		wp_enqueue_script( $label );
		wp_register_style( $label, "{$this->build_url}/Admin.css", array( 'wp-components' ), $version );
		wp_enqueue_style( $label );
		$this->enqueue_shared_script();
	}

	/**
	 * Extracts the version for the specified build from the build asset file
	 * @param string $build_name Name of the build
	 * @return string
	 */
	protected function get_version_for_build( string $build_name ): string {
		$meta = include( "{$this->root_dir}/build/{$build_name}.asset.php" );
		$version = 1;
		if ( $meta && isset( $meta['version'] ) ) {
			$version = $meta['version'];
		}
		return $version;
	}

	public function append_shared_data( array $shared_data = array() ): array {
		$this->integration_settings = $this->integration_settings_repository->show();
		$shared_data = array_merge( $shared_data, array(
			'namespace'               => $this->namespace,
			'nonce'                   => wp_create_nonce( 'wp_rest' ),
			'integration_can_connect' => $this->integration_settings->get_can_connect(),
			'routes'                  => $this->get_routes(),
			'fallback_image'          => $this->fallback_image,
		) );
		$user = $this->user_repository->show_current();
		if ( $user ) {
			$userdata = get_userdata( $user->ID );
			$user_roles = $userdata->roles;
			$shared_data['user_can_connect'] = $user->get_can_connect();
			$shared_data['user_roles'] = $user_roles;
		}
		return $shared_data;
	}

	protected function get_routes(): array {
		return array(
			'api'   => $this->api_route_repository->index_formatted(),
			'admin' => $this->admin_route_repository->index_formatted(),
			'post'  => $this->post_route_repository->index_formatted(),
			'term'  => $this->term_route_repository->index_formatted(),
			'web'   => $this->web_route_repository->index_formatted(),
		);
	}

	protected function enqueue_shared_script(): void {
		$shared_data = apply_filters( "{$this->namespace}_shared_data", array() );
		$shared_data = json_encode( $shared_data );
		ob_start();
		?>
		<script>
			( function() {
				if ( !window?.tokenpassData ) {
					window.tokenpassData = {}
				}
				window.tokenpassData.shared = <?php echo $shared_data ?>;
			} )();
		</script>
		<?php
		$script = ob_get_clean();
		$script = strip_tags( $script );
		wp_register_script( "{$this->namespace}_shared_data", false, array(), false, false );
		wp_enqueue_script( "{$this->namespace}_shared_data" );
		wp_add_inline_script( "{$this->namespace}_shared_data", $script );
	}
}
