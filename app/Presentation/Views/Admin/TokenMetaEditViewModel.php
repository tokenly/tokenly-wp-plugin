<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TokenMetaEditViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface;

class TokenMetaEditViewModel extends ViewModel implements TokenMetaEditViewModelInterface {
	protected $meta_service;
	
	public function __construct(
		MetaServiceInterface $meta_service
	) {
		$this->meta_service = $meta_service;
	}
	
	public function prepare( array $data = array() ) {
		$meta = $this->meta_service->show( array( 'id' => get_the_ID() ) );
		if ( $meta && is_object( $meta ) ) {
			$meta = $meta->to_array();
		}
		return array(
			'meta' => $meta,
		);
	}
}
