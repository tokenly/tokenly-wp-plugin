<?php

namespace Tokenly\Wp\Services\Application\Routers\Columns;

use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\ListingRouterInterface;

use Twig\Environment;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Collections\Routes\Listings\ColumnCollection;
use Tokenly\Wp\Collections\Routes\Listings\ActionCollection;
use Tokenly\Wp\Interfaces\Models\Routes\Listings\ColumnInterface;

/**
 * Manages routing for the post type views
 */
class ListingRouter extends Router implements ListingRouterInterface {
	protected Environment $twig;
	protected string $default_template = 'Dynamic.twig';
	protected string $column_type;
	protected string $action_type;
	protected string $action_class_collection = ActionCollection::class;
	protected string $column_class_collection = ColumnCollection::class; 
	
	public function __construct(
		string $namespace,
		Environment $twig
	) {
		$this->twig = $twig;
		parent::__construct( $namespace );
	}

	public function register_actions( callable $new_actions ): void {
		add_action( 'admin_init', function() use ( $new_actions ) {
			$filter = "{$this->namespace}_{$this->action_type}_row_actions";
			$callback = function(
				array $actions,
				object $target
			) use ( $new_actions ) {
				$new_actions = $new_actions( $target );
				$collection = new $this->action_class_collection();
				$new_actions = $collection->from_array( $new_actions );
				$new_actions = array_map( function( $action ) {
					return $action->get_html();
				}, ( array ) $new_actions );
				$actions = array_merge( $actions, $new_actions );
				return $actions;
			};
			add_filter( $filter, $callback, 10, 2 );
		} );
	}

	/**
	 * @inheritDoc
	 */
	public function register_columns( array $new_columns = array() ): void {
		$new_columns = ( new $this->column_class_collection() )->from_array(
			$new_columns
		);
		add_action( 'admin_init', function() use ( $new_columns ) {
			foreach ( $new_columns as $key => $column ) {
				$this->register_column( $key, $column, $this->column_type );
			}
		} );
	}

	/**
	 * @inheritDoc
	 */
	public function register_column(
		string $key,
		ColumnInterface $column,
		string $type
	): void {
		$callback_render = $this->get_column_render_callback( $key, $column );
		$callback_register = $this->get_column_register_callback(
			$key,
			$column
		);
		add_filter( "manage_{$type}_columns", $callback_register );
		add_action( "manage_{$type}_custom_column", $callback_render, 10, 3 );
	}

	protected function get_column_render_callback(
		$key,
		ColumnInterface $column
	): callable {
		return function(){};
	}

	protected function get_column_register_callback(
		$key,
		ColumnInterface $column
	): callable {
		return function(){};
	}
}
