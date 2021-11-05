<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface SettingsRepositoryInterface {
	public function show();
	public function update( $settings );
	public function is_configured();
}
