<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\TaxonomyServiceProviderInterface;

use Invoker\InvokerInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;

/**
 * Registers taxonomies
 */
class TaxonomyServiceProvider extends ServiceProvider implements TaxonomyServiceProviderInterface {
	protected string $root_dir;
	protected string $namespace;
	protected string $text_domain;
	protected array $repositories = array();
	protected InvokerInterface $invoker;
	protected TermRepositoryInterface $term_repository;

	public function __construct(
		string $root_dir,
		string $namespace,
		string $text_domain,
		InvokerInterface $invoker,
		TermRepositoryInterface $term_repository
	) {
		$this->invoker = $invoker;
		$this->root_dir = $root_dir;
		$this->namespace = $namespace;
		$this->text_domain = $text_domain;
		$this->term_repository = $term_repository;
		$this->services = array(
			'token_category' => array(
				'types' => array( "{$this->namespace}_token_meta" ),
				'data'  => array(
					'text_domain' => $text_domain,
				),
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		foreach ( $this->services as $key => $taxonomy_definition ) {
			$this->register_taxonomy( $key, $taxonomy_definition );
		}
		$this->register_hooks();
	}

	protected function register_taxonomy(
		string $key,
		array $taxonomy_definition
	): void {
		$data = $taxonomy_definition['data'];
		$types = $taxonomy_definition['types'];
		$path = "{$this->root_dir}/taxonomies/{$key}.php";
		$taxonomy = $this->invoker->call( include( $path ), $data );
		$name = "{$this->namespace}_{$key}";
		if ( isset( $taxonomy['repository'] ) ) {
			$this->repositories[ $name ] = $taxonomy['repository'];
		}
		register_taxonomy( $name, $types, $taxonomy );
		$this->taxonomies[ $name ] = $taxonomy;
	}

	protected function get_repository(
		string $taxonomy
	): RepositoryInterface {
		$repository = $this->term_repository;
		if ( isset( $this->repositories[ $taxonomy ] ) ) {
			$repository = $this->repositories[ $taxonomy ];
		}
		return $repository;
	}

	protected function complete_term( \WP_Term $term ): ?TermInterface {
		$repository = $this->get_repository( $term->taxonomy );
		if ( method_exists( $repository, 'complete' ) ) {
			$term = $repository->complete( $term );
			return $term;
		}
		return null;
	}

	protected function register_hooks(): void {
		$taxonomies = get_taxonomies();
		$this->register_saved_hook( $taxonomies );
		$this->register_edit_form_hook( $taxonomies );
		$this->register_template_redirect_hook( $taxonomies );
	}

	protected function register_saved_hook( array $taxonomies ): void {
		foreach ( $taxonomies as $taxonomy ) {
			$callback = function(
				int $term_id, int $tt_id, bool $update
			) use ( $taxonomy ) {
				$term = get_term( $term_id, $taxonomy );
				$term = $this->complete_term( $term );
				$action = "{$this->namespace}_saved_{$term->taxonomy}";
				do_action( $action, $term, $update );
			};
			add_action( "saved_{$taxonomy}", $callback, 10, 3 );
		}
	}

	protected function register_edit_form_hook( array $taxonomies ): void {
		foreach ( $taxonomies as $taxonomy ) {
			$callback = function( \WP_Term $term, string $taxonomy ) {
				$action = "{$this->namespace}_{$term->taxonomy}_edit_form";
				$term = $this->complete_term( $term );
				do_action( $action, $term, $taxonomy );
			};
			add_action( "{$taxonomy}_edit_form", $callback, 10, 2 );
		}
	}

	protected function register_template_redirect_hook(
		array $taxonomies = array()
	): void {
		add_action( "template_redirect", function() {
			$object = get_queried_object();
			if ( $object instanceof \WP_Term === false ) {
				return;
			}
			$term = $object;
			$term = $this->complete_term( $term );
			do_action( "{$this->namespace}_template_redirect_term", $term );
		}, 10, 0 );
		foreach ( $taxonomies as $taxonomy ) {
			$callback = function() use ( $taxonomy ) {
				$object = get_queried_object();
				if ( $object instanceof \WP_Term === false ) {
					return;
				}
				$term = $object;
				$term_taxonomy = $term->taxonomy;
				if ( $term_taxonomy != $taxonomy ) {
					return;
				}
				$action =
					"{$this->namespace}_template_redirect_term_{$term_taxonomy}";
				$term = $this->complete_term( $term );
				do_action( $action, $term );
			};
			add_action( "template_redirect", $callback, 10, 0 );
		}
	}
}
