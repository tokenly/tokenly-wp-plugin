<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;

interface PromiseControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, PromiseCollectionInterface $promises ): array;
	public function show( \WP_REST_Request $request, PromiseInterface $promise ): ?array;
	public function store( \WP_REST_Request $request ): ?array;
	public function update( \WP_REST_Request $request, PromiseInterface $promise ): void;
	public function destroy( \WP_REST_Request $request, PromiseInterface $promise ): void;
}
