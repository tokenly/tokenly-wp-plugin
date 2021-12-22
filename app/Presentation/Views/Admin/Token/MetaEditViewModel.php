<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\MetaEditViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

class MetaEditViewModel extends ViewModel implements MetaEditViewModelInterface {
	protected $token_meta_service;
	
	public function __construct(
		TokenMetaServiceInterface $token_meta_service
	) {
		$this->token_meta_service = $token_meta_service;
	}
	
	public function prepare( array $data = array() ) {
		$meta = $this->token_meta_service->show( array( 'id' => get_the_ID() ) );
		if ( $meta && is_object( $meta ) ) {
			$meta = $meta->to_array();
		}
		return array(
			'meta' => $meta,
		);
	}
}
