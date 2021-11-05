<?php

namespace Tokenly\Wp\Interfaces\Services;

interface UserServiceInterface {
	public function get_by_uuid( $uuid );
}
