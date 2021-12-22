<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionStoreViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

class TransactionStoreViewModel extends ViewModel implements TransactionStoreViewModelInterface {
	protected $credit_group_service;
	
	public function __construct(
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_service = $credit_group_service;
	}
	
	public function prepare( array $data = array() ) {
		$credit_groups = $this->credit_group_service->index();
		if ( $credit_groups && is_object( $credit_groups ) ) {
			$credit_groups = $credit_groups->to_array();
		}
		return array(
			'credit_groups' => $credit_groups,
		);
	}
}
