<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;

interface AddressControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, AddressCollectionInterface $addresses ): \WP_REST_Response;
	public function show( \WP_REST_Request $request, AddressInterface $address = null ): \WP_REST_Response;
	public function balance_index( \WP_REST_Request $request, AddressInterface $address ): \WP_REST_Response;
}
