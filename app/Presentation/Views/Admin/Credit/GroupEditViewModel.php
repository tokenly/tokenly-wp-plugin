<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupEditViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;

class GroupEditViewModel extends ViewModel implements GroupEditViewModelInterface {
	protected $group_service;
	
	public function __construct(
		GroupServiceInterface $group_service
	) {
		$this->group_service = $group_service;
	}
	
	public function prepare( array $data = array() ) {
		$credit_group_uuid = $data['credit_group_uuid'];
		$credit_group = $this->group_service->show( array(
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
