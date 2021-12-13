<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

class CreditGroupIndexViewModel extends ViewModel implements CreditGroupIndexViewModelInterface {
	protected $credit_group_service;
	
	public function __construct(
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_service = $credit_group_service;
	}
	
	public function prepare( array $data = array() ) {
		$groups = $this->credit_group_service->index();
		if ( $groups && is_object( $groups ) ) {
			$groups = $groups->to_array();
		} else {
			$groups = array();
		}
		return array(
			'credit_groups' => $groups,
		);
	}
}
