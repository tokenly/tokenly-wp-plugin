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
		return $this->promise_repository->index();
	}

	public function store( $request ) {
		$params = $request->get_params();
		$promies = $this->promise_repository->store( $params );
		return $promise;
	}
}
