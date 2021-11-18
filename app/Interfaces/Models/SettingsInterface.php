<?php

namespace Tokenly\Wp\Interfaces\Models;

interface SettingsInterface {
	public function update( $settings_data );
	public function save();
}
