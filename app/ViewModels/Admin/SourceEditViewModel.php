<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class SourceEditViewModel {
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
