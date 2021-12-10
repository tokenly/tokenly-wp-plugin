<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditTransactionIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;

class CreditTransactionIndexViewModel extends ViewModel implements CreditTransactionIndexViewModelInterface {
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
		$transactions = $this->credit_transaction_service->index( $params );
		if ( $transactions ) {
			$transactions = $transactions->to_array();
		} else {
			$transactions = array();
		}
		return array(
			'credit_transactions' => $transactions,
		);
	}
}
