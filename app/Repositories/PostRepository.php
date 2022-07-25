<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;

use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

/**
 * Manages post data
 */
	protected string $class = Post::class;
	protected string $class_collection = PostCollection::class;
	protected PostMetaRepositoryInterface $meta_repository;
	protected array $meta = array();
	protected string $post_type = 'any';
	protected TermRepositoryInterface $term_repository;

	public function __construct(
		PostMetaRepositoryInterface $meta_repository,
		TermRepositoryInterface $term_repository
	) {
		$this->meta_repository = $meta_repository;
		$this->term_repository = $term_repository;
		$this->meta = $this->get_meta_fields();
		$this->post_type = $this->get_post_type();
	}

	/**
	 * Queries all the posts matching the params
	 * @param array $params Search params
	 * @return PostCollectionInterface
	 */
	public function index(
		array $params = array()
	): PostCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Searches for post using the specified parameters
	 * @param array $params Post search params 
	 * @return PostInterface|null
	 */
	public function show( array $params = array() ): ?PostInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Creates a new post
	 * @param array $params New post data
	 * @return PostInterface|null $post New post
	 */
	public function store( array $params ): ?PostInterface {
		$post = $this->get_store_existing_post( $params );
		if ( $post ) {
			$post = $this->update( $post, $params );
		} else {
			$store_params = $this->get_store_args( $params );
			$post = wp_insert_post( $store_params );
			if ( is_int( $post ) ) {
				$post = $this->show( array(
					'id' => $post,
				) );
				$this->update( $post, $params );
			}
		}
		return $post;
	}

	/**
	 * Decorates and updates the post
	 * @return void
	 */
	public function update(
		PostInterface $post,
		array $params = array()
	): PostInterface {
		$params = $this->filter_meta_params( $params );
	
		$this->meta_repository->update( $post->ID, $params );
		$post = $this->complete( $post->post );
		return $post;
	}

	/**
	 * Deletes the existing post
	 * @param object $post Post to delete
	 * @return void
	 */
	public function destroy( PostInterface $post ): void {
		wp_delete_post( $post->ID );
	}
	
	/**
	 * Decorates a single post
	 * @param \WP_Post $post Post to decorate
	 * @return PostInterface|null
	 */
	public function complete( \WP_Post $post ): ?PostInterface {
		$post = $this->append_meta( $post );
		$post = ( new $this->class() )->from_array( $post );
		return $post;
	}
	
	/**
	 * Decorates a collection of posts
	 * @param \WP_Post[] $posts Posts to decorate
	 * @return PostCollectionInterface
	 */
	public function complete_collection(
		array $posts = array()
	): PostCollectionInterface {
		$posts = $this->append_meta_collection( $posts );
		$posts = ( new $this->class_collection() )->from_array( $posts );
		return $posts;
	}
	
	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search params
	 * @return PostCollectionInterface
	 */
	protected function index_cacheable(
		array $params = array()
	): PostCollectionInterface {
		$args = $this->get_query_args( $params );
		$posts = $this->query( $args );
		$posts = $this->complete_collection( $posts );
		return $posts;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Post search params 
	 * @return PostInterface|null
	 */
	protected function show_cacheable(
		array $params = array()
	): ?PostInterface {
		$params['posts_per_page'] = 1;
		$args = $this->get_query_args( $params );
		$posts = $this->query( $args );
		if ( !isset( $posts[0] ) ) {
			return null;
		}
		$post = $posts[0];
		$post = $this->complete( $post );
		return $post;
	}

	/**
	 * Filters the specified array accoring to the meta property
	 * @param array $params Array to filter
	 * @return array $params Params filtered
	 */
	protected function filter_meta_params( array $params = array() ): array {
		foreach ( $params as $key => $param ) {
			if ( !in_array( $key, $this->meta ) ) {
				unset( $params[ $key ] );
			}
		}
		return $params;
	}

	/**
	 * Checks if the post already exists before storing a new one
	 * @param array $params Store params
	 * @return PostInterface|null $post Post found
	 */
	protected function get_store_existing_post(
		array $params = array()
	): ?PostInterface {
		if ( !isset( $params['id'] ) ) {
			return null;
		}
		$post = $this->show( array(
			'id' => array( $params['id'] ),
		) );
		return $post;
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields(): array {
		return array(
			'tca_rules',
		);
	}

	/**
	 * Gets the post type name associated with the repository
	 * @return string
	 */
	protected function get_post_type(): string {
		return 'any';
	}

	/**
	 * Gets the query arguments for the Show and Index methods
	 * @param array $params Search parameters
	 * @return array
	 */
	protected function get_query_args( array $params = array() ): array {
		$args = array(
			'meta_query' => array(),
			'post_type'  => $this->post_type,
		);
		if ( isset( $params['posts_per_page'] ) ) {
			$args['posts_per_page'] = $params['posts_per_page'];
		}
		if ( isset( $params['id'] ) ) {
			$args['p'] = $params['id'];
		}
		if ( isset( $params['ids'] ) ) {
			$args['post__in'] = $params['ids'];
		}
		return $args;
	}

	/**
	 * Gets the arguments for the Store method
	 * @param array $params Store parameters
	 * @return array $args
	 */
	protected function get_store_args( array $params = array() ): array {
		$args = array(
			'post_type'  => $this->post_type,
		);
		return $args;
	}

	/**
	 * Searches for posts using the specified arguments
	 * @param array $args Search arguments
	 * @return array
	 */
	protected function query( array $args = array() ): array {
		$query = new \WP_Query( $args );
		$posts = $query->posts;
		return $posts;
	}

	/**
	 * Gets the meta fields associated with the post type
	 * after retrieving the post
	 * @param \WP_Post $post Post to target
	 * @return array
	 */
	protected function load_meta( \WP_Post $post ): array {
		$meta = $this->meta_repository->index( $post->ID, $this->meta );
		return $meta;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_Post $post Post to target
	 * @return array
	 */
	protected function append_meta( \WP_Post $post ): array {
		$meta = $this->load_meta( $post );
		$meta = $this->format_item( $meta );
		$post = array_merge( array(
			'post' => $post,
		), $meta );
		return $post;
	}

	/**
	 * Loads the meta for a collection of posts
	 * @param array $posts Posts to target
	 * @return array
	 */
	protected function append_meta_collection(
		array $posts = array()
	): array {
		foreach ( $posts as &$post ) {
			$post = $this->append_meta( $post );
		}
		return $posts;
	}

	/**
	 * Loads the term relation
	 * @param PostInterface $post Target Post
	 * @param string[] $relations Further relations
	 * @return TermCollectionInterface
	 */
	protected function load_term(
		PostInterface $post,
		array $relations = array()
	): TermCollectionInterface {
		$term = $this->term_repository->index( array(
			'id' => $post->ID,
		) );
		return $term;
	}
}
