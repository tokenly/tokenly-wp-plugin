<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\AddressInterface;

interface AddressBalanceControllerInterface extends ControllerInterface {
	public function index( AddressInterface $address, \WP_REST_Request $request );
}
