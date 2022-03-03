<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

interface TransactionControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, TransactionCollectionInterface $transacitons ): array;
}
