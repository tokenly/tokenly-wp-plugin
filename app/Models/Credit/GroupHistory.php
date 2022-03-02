<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupHistoryInterface;

use Tokenly\Wp\Collections\Credit\TransactionCollection;

class GroupHistory extends Model implements GroupHistoryInterface {
	protected ?float $balance = null;
	protected ?int $count = null;
	protected ?TransactionCollectionInterface $transactions = null;

	public function get_balance(): ?float {
		return $this->balance ?? null;
	}

	public function set_balance( ?float $value ): void {
		$this->balance = $value;
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
			'balance' => $this->get_balance(),
			'count'   => $this->get_count(),
		);
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
			'balance',
			'count',
			'transactions',
		) );
	}
}
