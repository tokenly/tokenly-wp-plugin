<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface SettingsControllerInterface {
	public function show( $request );
	public function update( $request );
}
