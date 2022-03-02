<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountHistoryInterface;

use Tokenly\Wp\Models\Credit\Account;
use Tokenly\Wp\Collections\Credit\TransactionCollection;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

class AccountHistory extends Model implements AccountHistoryInterface {
	protected ?AccountInterface $account = null;
	protected ?int $count = null;
	protected ?TransactionCollectionInterface $transactions = null;

	public function get_account(): ?AccountInterface {
		return $this->account ?? null;
	}

	public function set_account( ?AccountInterface $value ): void {
		$this->account = $value;
	}

	public function get_count(): ?int {
		return $this->count ?? null;
	}

	public function set_count( ?int $value ): void {
		$this->count = $value;
	}

	public function get_transactions(): ?TransactionCollectionInterface {
		return $this->transactions ?? null;
	}

	public function set_transactions( ?TransactionCollectionInterface $value ): void {
		$this->transactions = $value;
	}

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
			'count' => $this->get_count(),
		);
		if ( $this->get_account() ) {
			$array['account'] = $this->get_account()->to_array();
		}
		if ( $this->get_transactions() ) {
			$array['transactions'] = $this->get_transactions()->to_array();
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
