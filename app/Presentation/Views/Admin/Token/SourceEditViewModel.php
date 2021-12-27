<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceEditViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

class SourceEditViewModel extends DynamicViewModel implements SourceEditViewModelInterface {
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	protected function get_view_props( array $data = array() ) {
		$source = $data['source'];
		$source = $this->source_service->show( array(
			'address' => $source,
			'with'    => array(
				'address',
			),
		) );
		return array(
			'source' => $source,
		);
	}
}
