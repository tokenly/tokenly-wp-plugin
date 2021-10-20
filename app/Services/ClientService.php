<?php

namespace Tokenly\Wp\Services;

class ClientService {
	public function __construct() {
		//	
	}

	public function get_redirect_uri() {
		global $tokenly_routes;
		$api_routes = $tokenly_routes['api'] ?? null;
		if ( !$api_routes ) {
			return;
		}
		$redirect_uri = $api_routes['authorize-callback'] ?? null;
		return $redirect_uri;
	}
}
