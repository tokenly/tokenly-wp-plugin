<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

class CreditGroupShowViewModel {
	protected $credit_group_service;
	
	public function __construct(
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_service = $credit_group_service;
	}
	
	public function prepare( array $data = array() ) {
		$credit_group_uuid = $data['credit_group_uuid'];
		$credit_group = $this->credit_group_service->show( array(
			'group_uuid' => $credit_group_uuid,
		) );
		if ( $credit_group && is_object( $credit_group ) ) {
			$credit_group = $credit_group->to_array();
		}
		return array(
			'credit_group' => $credit_group,
		);
	}
}
