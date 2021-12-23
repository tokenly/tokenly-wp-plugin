<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceShowViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;

class SourceShowViewModel extends ViewModel implements SourceShowViewModelInterface {
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$source = $data['source'];
		$source = $this->source_service->show( array(
			'address' => $source,
			'with'    => array(
				'address',
			),
		) );
		if ( $source && is_object( $source ) ) {
			$source = $source->to_array();
		}
		return array(
			'source' => $source,
		);
	}
}
