<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Repositories\SourceRepository;

class SourceController {
	public function __construct(
		SourceRepository $source_repository
	) {
		$this->source_repository = $source_repository;
	}
	
	public function index( $request ) {
		$sources = $this->source_repository->index();
		return $sources;
	}

	public function store( $request ) {
		$params = $request->get_params();
		$source = $this->source_repository->store( $params );
		return $source;
	}

	public function update( $request ) {
		$address = (string) $request['address'];
		$params = $request->get_params();
		$source = $this->source_repository->update( $address, $params );
		return $source;
	}

	public function destroy( $request ) {
		$address = (string) $request['address'];
		$this->source_repository->destroy( $address );
		return array(
			'status' => "Address successfully destroyed!",
		);
	}
}
