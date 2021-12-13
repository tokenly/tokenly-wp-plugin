<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class SourceStoreViewModel extends ViewModel implements SourceStoreViewModelInterface {
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
