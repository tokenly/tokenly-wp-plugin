<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api;

interface IntegrationSettingsControllerInterface {
	public function show( $request );
	public function update( $request );
}
