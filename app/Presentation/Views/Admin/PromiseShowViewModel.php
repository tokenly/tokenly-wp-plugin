<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseShowViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;

class PromiseShowViewModel extends ViewModel implements PromiseShowViewModelInterface {
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
