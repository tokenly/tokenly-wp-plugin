<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\BalancesShowViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;

class BalancesShowViewModel extends ViewModel implements BalancesShowViewModelInterface {
	protected $address_service;
	
	public function __construct(
		AddressServiceInterface $address_service
	) {
		$this->address_service = $address_service;
	}
	
	public function prepare( array $data = array() ) {
		$address = $data['address'];
		$address = $this->address_service->show(
			array(
				'address' => $address,
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


