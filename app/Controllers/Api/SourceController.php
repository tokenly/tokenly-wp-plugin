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
		return $this->source_repository->index();
	}

	public function store( $request ) {
		$source_data = $request['source_data'] ?? null;
		if ( !$source_data ) {
			return array(
				'status' => 'Error. Source was not stored.',
			);
		}
		$this->source_repository->store( $source_data );
		return array(
			'status' => 'Source has been stored successfully.',
		);
	}
}
