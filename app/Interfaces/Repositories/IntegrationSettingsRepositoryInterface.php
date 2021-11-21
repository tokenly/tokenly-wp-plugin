<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface IntegrationSettingsRepositoryInterface {
	public function show();
	public function update( $settings );
}
