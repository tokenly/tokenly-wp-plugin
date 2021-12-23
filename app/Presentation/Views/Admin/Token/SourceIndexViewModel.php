<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceIndexViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

class SourceIndexViewModel extends ViewModel implements SourceIndexViewModelInterface {
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$sources = $this->source_service->index( array(
			'with' => array(
				'address',
			),
		) );
		$sources = $sources->to_array();
		return array(
			'sources' => $sources,
		);
	}
}
