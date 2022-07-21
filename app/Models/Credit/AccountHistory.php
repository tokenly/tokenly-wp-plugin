<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountHistoryInterface;

use Tokenly\Wp\Models\Credit\Account;
use Tokenly\Wp\Collections\Credit\TransactionCollection;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

class AccountHistory extends Model implements AccountHistoryInterface {
	public ?AccountInterface $account = null;
	public ?int $count = null;
	public ?TransactionCollectionInterface $transactions = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['account'] ) && is_array( $data['account'] ) ) {
			$data['account'] = ( new Account() )->from_array( $data['account'] );
		}
		if ( isset( $data['transactions'] ) && is_array( $data['transactions'] ) ) {
			$data['transactions'] = ( new TransactionCollection() )->from_array( $data['transactions'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'count' => $this->count,
		);
		if ( $this->account ) {
			$array['account'] = $this->account->to_array();
		}
		if ( $this->transactions ) {
			$array['transactions'] = $this->transactions->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'account',
			'count',
			'transactions',
		) );
	}
}
