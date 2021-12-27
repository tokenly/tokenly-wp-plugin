<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Credit;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

interface GroupControllerInterface extends ControllerInterface {
	public function index( GroupCollectionInterface $groups, \WP_REST_Request $request );
	public function show( GroupInterface $group, \WP_REST_Request $request );
	public function store( \WP_REST_Request $request );
	public function update( GroupInterface $group, \WP_REST_Request $request );
	public function destroy( GroupInterface $group, \WP_REST_Request $request );
}
