<?php

namespace Tokenly\Wp\Interfaces\Providers;

interface AppServiceProviderInterface {
	public function enqueue_frontend_scripts();
	public function enqueue_admin_scripts();
	public static function on_activation();
	public static function on_uninstall();
}
