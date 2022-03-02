<?php

namespace Tokenly\Wp\Interfaces\Services\Application;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

interface AuthServiceInterface extends ServiceInterface {
	public function authorize_begin( string $success_url );
	public function authorize_callback( string $state, string $code );
	public function embed_tokenpass_login();
}
