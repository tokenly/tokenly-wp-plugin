<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;

interface PromiseControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, PromiseCollectionInterface $promises ): \WP_REST_Response;
	public function show( \WP_REST_Request $request, PromiseInterface $promise ): \WP_REST_Response;
	public function store( \WP_REST_Request $request ): \WP_REST_Response;
	public function update( \WP_REST_Request $request, PromiseInterface $promise ): \WP_REST_Response;
	public function destroy( \WP_REST_Request $request, PromiseInterface $promise ): \WP_REST_Response;
}
