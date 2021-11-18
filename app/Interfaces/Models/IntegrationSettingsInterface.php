<?php

namespace Tokenly\Wp\Interfaces\Models;

interface IntegrationSettingsInterface {
	public function update( $settings_data );
	public function save();
}
