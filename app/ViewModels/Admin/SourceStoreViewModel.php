<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class SourceStoreViewModel {
	protected $current_user;
	
	public function __construct(
		CurrentUserInterface $current_user
	) {
		$this->current_user = $current_user;
	}
	
	public function prepare( array $data = array() ) {
		$this->current_user->load( array( 'oauth_user' ) );
		$address = array();
		if ( isset( $this->current_user->oauth_user ) ) {
			$oauth_user = $this->current_user->oauth_user;
			$oauth_user->load( array( 'address.balance.token_meta' ) );
			if ( $oauth_user->address ?? null ) {
				$address = $oauth_user->address->to_array();
			}
		}
		return array(
			'addresses' => $address,
		);
	}
}
