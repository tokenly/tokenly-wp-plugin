<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

interface GroupControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, GroupCollectionInterface $groups ): \WP_REST_Response;
	public function show( \WP_REST_Request $request, GroupInterface $group ): \WP_REST_Response;
	public function store( \WP_REST_Request $request ): \WP_REST_Response;
	public function update( \WP_REST_Request $request, ?GroupInterface $group = null ): \WP_REST_Response;
	public function destroy( \WP_REST_Request $request, ?GroupInterface $group = null ): \WP_REST_Response;
}
