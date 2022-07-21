<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupHistoryInterface;

use Tokenly\Wp\Collections\Credit\TransactionCollection;

class GroupHistory extends Model implements GroupHistoryInterface {
	public ?float $balance = null;
	public ?int $count = null;
	public ?TransactionCollectionInterface $transactions = null;

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
			'balance' => $this->balance,
			'count'   => $this->count,
		);
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
			'balance',
			'count',
			'transactions',
		) );
	}
}
