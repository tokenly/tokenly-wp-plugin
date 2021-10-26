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
		$promise = $request['promise'] ?? null;
		if ( !$promise ) {
			return array(
				'status' => 'Error. Promise was not stored.',
			);
		}
		$this->promise_repository->store( $promise );
		return array(
			'status' => 'Promise has been stored successfully.',
		);
	}
}
