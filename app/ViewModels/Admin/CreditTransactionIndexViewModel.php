<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;

class CreditTransactionIndexViewModel {
	protected $credit_transaction_service;
	
	public function __construct(
		CreditTransactionServiceInterface $credit_transaction_service
	) {
		$this->credit_transaction_service = $credit_transaction_service;
	}
	
	public function prepare( array $data = array() ) {
		$params = array(
			'group_uuid' => $data['group_uuid'],
		);
		$credit_transactions = $this->credit_transaction_service->index( $params );
		if ( $credit_transactions ) {
			$credit_transactions = $credit_transactions->to_array();
		} else {
			$credit_transactions = array();
		}
		return array(
			'credit_group' => $credit_group,
		);
	}
}
