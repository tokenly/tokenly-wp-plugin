<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

interface BalanceControllerInterface extends ControllerInterface {
	public function index( BalanceCollectionInterface $balance, \WP_REST_Request $request );
}
