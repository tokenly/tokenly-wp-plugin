<?php

namespace Tokenly\Wp\Services\Application\Routers\Columns;

use Tokenly\Wp\Services\Application\Routers\Columns\ListingRouter;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\PostRouterInterface;

use Twig\Environment;
use Tokenly\Wp\Collections\Routes\Listings\PostActionCollection;
use Tokenly\Wp\Collections\Routes\Listings\PostColumnCollection;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ColumnInterface;

/**
 * Manages routing for the post type views
 */
class PostRouter extends ListingRouter implements PostRouterInterface {
	protected string $column_type = 'posts';
	protected string $action_type = 'post';
	protected string $column_class_collection = PostColumnCollection::class; 

	/**
	 * @inheritDoc
	 */
	public function register_columns( array $new_columns = array() ): void {
		$new_columns = ( new $this->column_class_collection() )->from_array(
			$new_columns
		);
		add_action( 'admin_init', function() use ( $new_columns ) {
			foreach ( $new_columns as $column ) {
				if ( !$column->post_type ) {
					$post_types = get_post_types();
				} else {
					$post_types = $column->post_type;
				}
				foreach ( $post_types as $post_type ) {
					$this->register_column(
						$post_type,
						$column,
						"{$post_type}_{$this->column_type}"
					);
				}
			}
		} );
	}

	protected function get_column_render_callback(
		$key,
		ColumnInterface $column
	): callable {
		return function(
			string $column_name, int $post_id
		) use ( $key, $column ) {
			$view_data = call_user_func( $column->callback, $post_id );
			$id = $column->id;
			$callback_render = function() use (
				$column, $view_data, $key, $id
			) {
				return array(
					'template' => 'Dynamic.twig',
					'view'     => "column-{$this->namespace}-{$key}-{$id}",
					'data'     => $view_data,
				);
			};
			$name = "{$this->namespace}-{$key}-{$id}";
			if ( $column_name == $name ) {
				$this->render_route( $callback_render );
			}
		};
	}

	protected function get_column_register_callback(
		$key,
		ColumnInterface $column
	): callable {
		return function( array $column_array ) use ( $key, $column ) {
			$id = $column->id;
			$column_array = array_slice( $column_array, 0, 1, true )
			+ array( "{$this->namespace}-{$key}-{$id}" => $column->title )
			+ array_slice( $column_array, 1, NULL, true );
			return $column_array;
		};
	}
}
