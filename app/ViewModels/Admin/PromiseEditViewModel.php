<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;

class PromiseEditViewModel {
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
		) );
		if ( !$promise ) {
			return false;
		}
		$promise = $promise->to_array();
		return array(
			'promise' => $promise,
		);
	}
}
