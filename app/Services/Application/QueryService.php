<?php

namespace Tokenly\Wp\Services\Application;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\QueryServiceInterface;

/**
 * Query functions
 */
class QueryService extends Service implements QueryServiceInterface {
	protected string $namespace;
	protected array $query_variables = array(
		//General
		'virtual',
		'promise',
		'source',
		'address',
		'user',
		'success_url',
		'group',
		//Routing
		'oauth_callback_page',
		'oauth_connect_page',
		'oauth_disconnect_page',
		'access_denied_page',
		'user_me_page',
		'user_page',
	);
	protected array $query_variables_external = array(
		'code',
		'state',
	);

	public function __construct(
		string $namespace
	) {
		$this->namespace = $namespace;	
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		add_filter( 'query_vars', array( $this, 'register_query_variables' ) );
	}

	/**
	 * Registers the custom query variables
	 * @param array $vars Default query variables
	 * @return array
	 */
	public function register_query_variables( array $vars ): array {
		foreach ( $this->query_variables as &$query_variable ) {
			$query_variable = "{$this->namespace}_{$query_variable}";
		}
		$vars = array_merge( $vars, $this->query_variables );
		$vars = array_merge( $vars, $this->query_variables_external );
		return $vars;
	}
}
