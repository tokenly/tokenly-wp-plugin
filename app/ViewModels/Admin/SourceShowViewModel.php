<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class SourceShowViewModel {
	protected $source_service;
	
	public function __construct(
		SourceServiceInterface $source_service
	) {
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$source = $this->source_service->show( array(
			'address' => $address,
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
