<?php

namespace Tokenly\Wp;

use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;

class Bootstrap {
	
	public function get_providers() {
		return array(
			AppServiceProvider::class,
			RouteServiceProvider::class,
			ShortcodeServiceProvider::class,
		);
	}

	public function boot() {
		$providers = $this->get_providers();
		foreach ( $providers as $provider ) {
			$provider = new $provider();
			$provider->boot();
		}
	}
}
