<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface TcaSettingsServiceInterface {
	public function show();
	public function update( array $settings = array() );
}
