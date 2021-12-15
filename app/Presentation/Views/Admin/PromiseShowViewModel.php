<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseShowViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

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
		if ( !isset( $data['promise'] ) ) {
			return;
		}
		$promise = $data['promise'];
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
