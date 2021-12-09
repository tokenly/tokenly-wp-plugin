<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;

class CreditGroupIndexViewModel {
	protected $credit_group_service;
	
	public function __construct(
		CreditGroupServiceInterface $credit_group_service
	) {
		$this->credit_group_service = $credit_group_service;
	}
	
	public function prepare( array $data = array() ) {
		$credit_transactions = $this->credit_transaction_service->index( $params );
		if ( $credit_transactions ) {
			$credit_transactions = $credit_transactions->to_array();
		} else {
			$credit_transactions = array();
		}
		return array(
			'credit_transactions' => $credit_transactions,
		);
	}
}
