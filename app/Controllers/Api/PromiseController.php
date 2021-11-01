<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Repositories\PromiseRepository;

class PromiseController {
	public function __construct(
		PromiseRepository $promise_repository
	) {
		$this->promise_repository = $promise_repository;
	}
	
	public function index( $request ) {
		$promises = $this->promise_repository->index();
		return $promises;
	}

	public function store( $request ) {
		$params = $request->get_params();
		$promise = $this->promise_repository->store( $params );
		return array(
			'promise' => $promise,
			'status'  => 'Promise created successfully',
		);
	}

	public function update( $request ) {
		$promise_id = (string) $request['promise'];
		$params = $request->get_params();
		$this->promise_repository->update( $promise_id, $params );
		return array(
			'status' => 'Promise successfully updated!',
		);
	}

	public function destroy( $request ) {
		$promise_id = (string) $request['promise'];
		$this->promise_repository->destroy( $promise_id );
		return array(
			'status' => "Promise successfully cancelled!",
		);
	}
}
