<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\VendorViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class VendorViewModel extends ViewModel implements VendorViewModelInterface {
	protected $promise_service;
	protected $source_service;
	protected $current_user;
	
	public function __construct(
		PromiseServiceInterface $promise_service,
		SourceServiceInterface $source_service,
		CurrentUserInterface $current_user
	) {
		$this->promise_service = $promise_service;
		$this->source_service = $source_service;
		$this->current_user = $current_user;
	}
	
	public function prepare( array $data = array() ) {
		if ( $this->current_user->is_guest() === true ) {
			return;
		}
		if ( $this->current_user->can_connect() === false ) {
			return;
		}
		$promises = $this->promise_service->index( array(
			'with' => array( 'promise_meta.source_user', 'promise_meta.destination_user' ),
		) );
		if ( $promises && is_object( $promises ) ) {
			$promises = $promises->to_array();
		}
		$sources = $this->source_service->index( array(
			'with' => array( 'address' ),
		) );
		if ( $sources && is_object( $sources ) ) {
			$sources = $sources->to_array();
		}
		return array(
			'promises' => $promises,
			'sources' => $sources,
		);
	}
}
