<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class SourceStoreViewModel extends DynamicViewModel implements SourceStoreViewModelInterface {
	protected $current_user;
	protected $user_service;
	protected $source_service;
	
	public function __construct(
		UserServiceInterface $user_service,
		SourceServiceInterface $source_service
	) {
		$this->user_service = $user_service;
		$this->current_user = $this->user_service->show_current();
		$this->source_service = $source_service;
	}
	
	protected function get_view_props( array $data = array() ) {
		if ( !$this->current_user || $this->current_user instanceof UserInterface === false ) {
			return;
		}
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
