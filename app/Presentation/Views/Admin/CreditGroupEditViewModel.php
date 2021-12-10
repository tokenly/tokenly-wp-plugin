<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupEditViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

class CreditGroupEditViewModel extends ViewModel implements CreditGroupEditViewModelInterface {
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
		if ( !$credit_group ) {
			return false;
		}
		$credit_group = $credit_group->to_array();
		return array(
			'credit_group' => $credit_group,
		);
	}
}
