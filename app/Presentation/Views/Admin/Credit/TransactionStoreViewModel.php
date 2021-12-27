<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;

class TransactionStoreViewModel extends DynamicViewModel implements TransactionStoreViewModelInterface {
	protected $group_service;
	
	public function __construct(
		GroupServiceInterface $group_service
	) {
		$this->group_service = $group_service;
	}
	
	protected function get_view_props( array $data = array() ) {
		$credit_groups = $this->group_service->index();
		if ( $credit_groups && is_object( $credit_groups ) ) {
			$credit_groups = $credit_groups->to_array();
		}
		return array(
			'credit_groups' => $credit_groups,
		);
	}
}
