<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\PostTypeServiceProviderInterface;

use Invoker\InvokerInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Registers post types
 */
class PostTypeServiceProvider extends ServiceProvider implements PostTypeServiceProviderInterface {
	protected string $root_dir;
	protected string $namespace;
	protected string $text_domain;
	protected InvokerInterface $invoker;
	protected PostRepositoryInterface $post_repository;
	protected array $post_types = array();
	protected array $repositories = array();

	public function __construct(
		string $root_dir,
		string $namespace,
		string $text_domain,
		InvokerInterface $invoker,
		PostRepositoryInterface $post_repository
	) {
		$this->invoker = $invoker;
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->text_domain = $text_domain;
		$this->post_repository = $post_repository;
		$this->services = array(
			'promise_meta' => array(
				'data' => array(
					'text_domain' => $text_domain,
				),
			),
			'token_meta' => array(
				'data' => array(
					'namespace'   => $namespace,
					'text_domain' => $text_domain,
				),
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		foreach ( $this->services as $key => $post_type_definition ) {
			$this->register_post_type( $key, $post_type_definition );
		}
		$this->register_hooks();
	}

	protected function register_post_type( string $key, array $post_type_definition ): void {
		$data = $post_type_definition['data'];
		$path = "{$this->root_dir}/post_types/{$key}.php";
		$post_type = $this->invoker->call( include( $path ), $data );
		$name = "{$this->namespace}_{$key}";
		if ( isset( $post_type['repository'] ) ) {
			$this->repositories[ $name ] = $post_type['repository'];
		}
		register_post_type( $name, $post_type );
		$this->post_types[ $name ] = $post_type;
	}

	protected function complete_post( \WP_Post $post ): ?PostInterface {
		$repository = $this->get_repository( $post->post_type );
		if ( method_exists( $repository, 'complete' ) ) {
			$post = $repository->complete( $post );
			return $post;
		}
		return null;
	}

	protected function get_repository( string $post_type ): RepositoryInterface {
		$repository = $this->post_repository;
		if ( isset( $this->repositories[ $post_type ] ) ) {
			$repository = $this->repositories[ $post_type ];
		}
		return $repository;
	}

	protected function register_hooks(): void {
		$post_types = get_post_types();
		$this->register_posts_results_hook();
		$this->register_save_post_hook( $post_types );
		$this->register_template_redirect_hook( $post_types );
		$this->register_add_meta_boxes_hook( $post_types );
	}

	protected function register_save_post_hook( array $post_types = array() ): void {
		foreach ( $post_types as $post_type ) {
			add_action( "save_post_{$post_type}", function( int $post_id, \WP_Post $post, bool $update ) use ( $post_type ) {
				$post = $this->complete_post( $post );
				do_action( "{$this->namespace}_save_post_{$post->post_type}", $post, $update );
			}, 10, 3 );
		}
	}

	protected function register_template_redirect_hook( array $post_types = array() ): void {
		add_action( "template_redirect", function() {
			$object = get_queried_object();
			if ( $object instanceof \WP_Post === false ) {
				return;
			}
			$post = $object;
			$post = $this->complete_post( $post );
			do_action( "{$this->namespace}_template_redirect_post", $post );
		}, 10, 0 );
		foreach ( $post_types as $post_type ) {
			add_action( "template_redirect", function() use ( $post_type ) {
				$object = get_queried_object();
				if ( $object instanceof \WP_Post === false ) {
					return;
				}
				$post = $object;
				if ( $post->post_type != $post_type ) {
					return;
				}
				$post = $this->complete_post( $post );
				do_action( "{$this->namespace}_template_redirect_post_{$post->post_type}", $post );
			}, 10, 0 );
		}
	}

	protected function register_posts_results_hook(): void {
		add_filter( "posts_results", function( array $posts, \WP_Query $query ) {
			$posts = $this->post_repository->complete_collection( $posts );
			$posts = apply_filters( "{$this->namespace}_posts_results", $posts, $query );
			return $posts;
		}, 10, 2 );
	}

	protected function register_add_meta_boxes_hook( array $post_types ): void {
		foreach ( $post_types as $post_type ) {
			add_action( "add_meta_boxes_{$post_type}", function( \WP_Post $post ) {
				$post = $this->complete_post( $post );
				do_action( "{$this->namespace}_add_meta_boxes_{$post->post_type}", $post );
			}, 10, 1 );
		}
	}
}


