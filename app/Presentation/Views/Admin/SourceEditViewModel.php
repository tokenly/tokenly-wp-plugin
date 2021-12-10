<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceEditViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class SourceEditViewModel extends ViewModel implements SourceEditViewModelInterface {
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$source_address = $data['source_address'];
		$source = $this->source_service->show( array(
			'address' => $source_address,
			'with'    => array(
				'address',
			),
		) );
		return array(
			'source' => $source,
		);
	}
}