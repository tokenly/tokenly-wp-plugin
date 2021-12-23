<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\TransactionIndexViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\TransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class TransactionIndexViewModel extends ViewModel implements TransactionIndexViewModelInterface {
	protected $transaction_service;
	protected $user_service;
	
	public function __construct(
		UserServiceInterface $user_service,
		TransactionServiceInterface $transaction_service
	) {
		$this->user_service = $user_service;
		$this->transaction_service = $transaction_service;
	}
	
	public function prepare( array $data = array() ) {
		$params = array(
			'group_uuid' => $data['group_uuid'],
			'with'       => array( 'user' ),
		);
		$transactions = $this->transaction_service->index( $params );
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
