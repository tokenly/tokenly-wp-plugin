<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PostCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

/**
 * Manages post data
 */
class PostRepository implements PostRepositoryInterface {
	protected $post_factory;
	protected $post_collection_factory;
	protected $meta_repository;
	protected $meta = array();
	protected $post_type = 'any';
	
	public function __construct(
		PostFactoryInterface $post_factory,
		PostCollectionFactoryInterface $post_collection_factory,
		MetaRepositoryInterface $meta_repository
	) {
		$this->post_factory = $post_factory;
		$this->post_collection_factory = $post_collection_factory;
		$this->meta_repository = $meta_repository;
		$this->meta = $this->get_meta_fields();
		$this->post_type = $this->get_post_type();
	}

	/**
	 * Queries all the posts matching the params
	 * @param array $params Search params
	 * @return object
	 */
	public function index( array $params = array() ) {
		$args = $this->get_query_args( $params );
		$posts = $this->query( $args );
		$posts = $this->append_meta_collection( $posts );
		$posts = $this->post_collection_factory->create( $posts );
		return $posts;
	}

	/**
	 * Retrieves a single token meta post
	 * @param integer $params Post search params
	 * @return object
	 */
	public function show( array $params = array() ) {
		$params['posts_per_page'] = 1;
		$args = $this->get_query_args( $params );
		$posts = $this->query( $args );
		if ( !isset( $posts[0] ) ) {
			return;
		}
		$post = $posts[0];
		$post = $this->append_meta( $post );
		$post = $this->post_factory->create( $post );
		return $post;
	}

	/**
	 * Creates a new post
	 * @param array $params New post data
	 * @return object
	 */
	public function store( array $params ) {
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
				$post->update( $params );
			}
		}
		return $post;
	}

	/**
	 * Updates the specific post
	 * @param object $post Target post
	 * @param array $params Update parameters
	 * @return object
	 */
	public function update( $post, array $params = array() ) {
		$params = $this->filter_meta_params( $params );
		$this->meta_repository->update( $post->ID, $params );
		return $post;
	}

	/**
	 * Deletes the existing post
	 * @param object $post Post to delete
	 * @return void 
	 */
	public function destroy( $post ) {
		wp_delete_post( $post->ID );
	}

	/**
	 * Filters the specified array accoring to the meta property
	 * @param array $params Array to filter
	 * @return array
	 */
	protected function filter_meta_params( array $params = array() ) {
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
	 * @return object
	 */
	protected function get_store_existing_post( $params ) {
		$post = $this->show( array(
			'id' => array( $params['id'] ),
		) );
		return $post;
	}

	/**
	 * Gets meta fields which are allowed to be persisted and retrieved
	 * @return array
	 */
	protected function get_meta_fields() {
		return array(
			'tca_rules',
		);
	}

	/**
	 * Gets the post type name associated with the repository
	 * @return string
	 */
	protected function get_post_type() {
		return 'any';
	}

	/**
	 * Gets the query arguments for the Show and Index methods
	 * @param array $params Search parameters
	 * @return array
	 */
	protected function get_query_args( array $params = array() ) {
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
		return $args;
	}

	/**
	 * Gets the arguments for the Store method
	 * @param array $params Store parameters
	 * @return array $args
	 */
	protected function get_store_args( array $params = array() ) {
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
	protected function query( array $args = array() ) {
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
	protected function load_meta( \WP_Post $post ) {
		$meta = $this->meta_repository->index( $post->ID, $this->meta );
		return $meta;
	}

	/**
	 * Loads the meta and appends it to array
	 * @param \WP_Post $post Post to target
	 * @return array
	 */
	protected function append_meta( \WP_Post $post ) {
		$meta = $this->load_meta( $post );
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
	protected function append_meta_collection( array $posts ) {
		foreach ( $posts as &$post ) {
			$post = $this->append_meta( $post );
		}
		return $posts;
	}
}
