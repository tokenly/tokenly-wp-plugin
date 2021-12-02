<?php

namespace Tokenly\Wp\Interfaces\Models;

interface IntegrationSettingsInterface {
	public function update( array $data = array() );
	public function save();
}
