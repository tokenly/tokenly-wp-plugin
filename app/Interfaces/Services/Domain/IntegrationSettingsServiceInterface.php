<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface IntegrationSettingsServiceInterface {
	public function show();
	public function update( array $settings = array() );
}
