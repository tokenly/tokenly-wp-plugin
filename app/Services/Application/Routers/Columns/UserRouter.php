<?php

namespace Tokenly\Wp\Services\Application\Routers\Columns;

use Tokenly\Wp\Services\Application\Routers\Columns\ListingRouter;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\UserRouterInterface;

use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Collections\Routes\Listings\UserActionCollection;
use Tokenly\Wp\Collections\Routes\Listings\UserColumnCollection;

/**
 * Manages routing for the post type views
 */
class UserRouter extends ListingRouter implements UserRouterInterface {
	protected string $column_type = 'users';
	protected string $action_type = 'user';
	protected string $column_class_collection = UserColumnCollection::class; 
	/**
	 * @inheritDoc
	 */
	public function register_columns( array $new_columns = array() ): void {
		$new_columns = ( new $this->column_class_collection() )->from_array( $new_columns );
		add_action( 'admin_init', function() use ( $new_columns ) {
			foreach ( ( array ) $new_columns as $key => $column ) {
				$this->register_column( $key, $column, $this->column_type );
			}
		} );
	}

	public function register_actions( callable $new_actions ): void {
		add_action( 'admin_init', function() use ( $new_actions ) {
			add_filter( "{$this->namespace}_{$this->action_type}_row_actions", function( array $actions, UserInterface $user ) use ( $new_actions ) {
				$new_actions = $new_actions( $user );
				$new_actions = ( new $this->action_class_collection() )->from_array( $new_actions );
				$new_actions = array_map( function( $action ) {
					return $action->get_html();
				}, ( array ) $new_actions );
				$actions = array_merge( $actions, $new_actions );
				return $actions;
			}, 10, 2 );
		} );
	}

	protected function get_column_render_callback( $key, $column ): callable {
		return function( string $output, string $column_name, int $user_id ) use ( $key, $column ) {
			$data = array();
			if ( $column->get_data() ) {
				$data = $column->get_data();
			}
			$view_data = call_user_func( $column->get_callback(), $user_id, $data );
			$callback_render = function() use ( $key, $column, $view_data ) {
				$id = $column->get_id();
				return array(
					'template' => 'Dynamic.twig',
					'view'     => "column-{$id}",
					'data'     => $view_data,
				);
			};
			$name = "{$this->namespace}-{$key}";
			if ( $column_name == $name ) {
				ob_start();
				$this->render_route( $callback_render );
				return ob_get_clean();
			}
			return $output;
		};
	}

	protected function get_column_register_callback( $key, $column ): callable {
		return function( array $column_array ) use ( $key, $column ) {
			$column_array = array_slice( $column_array, 0, count( $column_array ), true )
			+ array( "{$this->namespace}-{$key}" => $column->get_title() )
			+ array_slice( $column_array, 1, NULL, true );
			return $column_array;
		};
	}
}
