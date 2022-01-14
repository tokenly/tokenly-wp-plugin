<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;

interface PromiseControllerInterface extends ControllerInterface {
	public function index( PromiseCollectionInterface $promises, \WP_REST_Request $request );
	public function show( PromiseInterface $promise, \WP_REST_Request $request );
	public function store( \WP_REST_Request $request );
	public function update( PromiseInterface $promise, \WP_REST_Request $request );
	public function destroy( PromiseInterface $promise, \WP_REST_Request $request );
}
