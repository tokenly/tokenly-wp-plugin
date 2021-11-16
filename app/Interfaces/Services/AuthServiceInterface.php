<?php

namespace Tokenly\Wp\Interfaces\Services;

interface AuthServiceInterface {
	public function authorize_callback( string $state, string $code );
	public function embed_tokenpass_login();
	public function authorize_begin();
}
