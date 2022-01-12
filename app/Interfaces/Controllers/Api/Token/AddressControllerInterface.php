<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

interface AddressControllerInterface extends ControllerInterface {
	public function index( AddressCollectionInterface $addresses, \WP_REST_Request $request );
	public function balance_index( AddressInterface $address, \WP_REST_Request $request );
}
