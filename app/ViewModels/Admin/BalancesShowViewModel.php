<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;

class BalancesShowViewModel {
	protected $address_service;
	
	public function __construct(
		AddressServiceInterface $address_service
	) {
		$this->address_service = $address_service;
	}
	
	public function prepare( array $data = array() ) {
		$address = $this->address_service->show(
			array(
				'address' => $address_id,
				'with'    => array( 'balance.token_meta' ),
			)
		);
		if ( $address ) {
			$address = $address->to_array();
		}
		return array(
			'address' => $address,
		);
	}
}


