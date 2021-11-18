<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface AuthControllerInterface {
	public function status();
	public function authorize( $request );
	public function authorize_callback();
	public function disconnect();
}
