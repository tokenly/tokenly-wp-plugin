<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class SourceStoreViewModel extends ViewModel implements SourceStoreViewModelInterface {
	protected $current_user;
	protected $source_service;
	
	public function __construct(
		CurrentUserInterface $current_user,
		SourceServiceInterface $source_service
	) {
		$this->current_user = $current_user;
		$this->source_service = $source_service;
	}
	
	public function prepare( array $data = array() ) {
		$this->current_user->load( array( 'oauth_user.address.balance.token_meta' ) );
		$addresses = array();
		if (
			isset( $this->current_user->oauth_user ) &&
			isset( $this->current_user->oauth_user->address ) &&
			$this->current_user->oauth_user->address instanceof AddressCollectionInterface
		) {
			$addresses = clone $this->current_user->oauth_user->address;
			$addresses->filter_registered();
			$addresses = $addresses->to_array();
		}
		return array(
			'addresses' => $addresses,
		);
	}
}
