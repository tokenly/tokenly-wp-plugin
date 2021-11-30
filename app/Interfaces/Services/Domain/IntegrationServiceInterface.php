<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface IntegrationServiceInterface {
	public function show();
	public function check_connection();
	public function update( array $new_data = array() );
	public function can_connect();
}
