<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\PromiseShowViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

class PromiseShowViewModel extends ViewModel implements PromiseShowViewModelInterface {
	protected $promise_service;
	protected $source_service;
	
	public function __construct(
		PromiseServiceInterface $promise_service,
		SourceServiceInterface $source_service
	) {
		$this->promise_service = $promise_service;
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$promise_id = $data['promise_id'];
		$promise = $this->promise_service->show( array(
			'promise_id' => $promise_id,
			'with'       => array(
				'source.address',
				'promise_meta.source_user',
				'promise_meta.destination_user'
			),
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
