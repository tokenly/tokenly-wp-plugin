<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;

/**
 * Query functions
 */
class QueryService extends Service implements QueryServiceInterface {
	protected $namespace;
	protected $query_variables = array(
		//General
		'virtual',
		'promise',
		'source',
		'address',
		'user_id',
		'success_url',
		'group',
		//Routing
		'oauth_callback',
		'oauth_connect',
		'oauth_disconnect',
		'access_denied',
	);
	protected $query_variables_external = array(
		'code',
		'state',
	);

	public function __construct(
		string $namespace
	) {
		$this->namespace = $namespace;	
	}

	/**
	 * Registers the service
	 * @return void
	 */
	public function register() {
		add_filter( 'query_vars', array( $this, 'register_query_variables' ) );
	}

	/**
	 * Registers the custom query variables
	 * @param array $vars Default query variables
	 * @return array
	 */
	public function register_query_variables( array $vars ) {
		foreach ( $this->query_variables as &$query_variable ) {
			$query_variable = "{$this->namespace}_{$query_variable}";
		}
		$vars = array_merge( $vars, $this->query_variables );
		$vars = array_merge( $vars, $this->query_variables_external );
		return $vars;
	}
}
