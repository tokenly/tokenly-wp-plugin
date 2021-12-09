<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;

class PromiseShowViewModel {
	protected $promise_service;
	
	public function __construct(
		PromiseServiceInterface $promise_service
	) {
		$this->promise_service = $promise_service;
	}
	
	public function prepare( array $data = array() ) {
		$promise_id = $data['promise_id'];
		$promise = $this->promise_service->show( array(
			'promise_id' => $promise_id, 
			'with'       => array(
				'promise_meta.source_user',
				'promise_meta.destination_user'
			),
		) );
		if ( !$promise ) {
			return;
		}
		$promise = $promise->to_array();
		$sources = $this->source_service->index( array(
			'with' => array( 'address' ),
		) );
		$sources = $sources->to_array();
		return array(
			'promise' => $promise,
			'sources' => $sources,
		);
	}
}
