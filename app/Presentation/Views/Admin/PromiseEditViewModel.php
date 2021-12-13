<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseEditViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;

class PromiseEditViewModel extends ViewModel implements PromiseEditViewModelInterface {
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
