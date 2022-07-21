<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionInterface;

class Transaction extends Model implements TransactionInterface {
	public ?string $tx_uuid = null;
	public ?string $credit_group = null;
	public ?string $account = null;
	public ?string $account_uuid = null;
	public ?float $amount = null;
	public ?string $oauth_user_id = null;
	public ?string $ref = null;
	public ?string $created_at = null;
	public ?string $updated_at = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'tx_uuid'       => $this->tx_uuid,
			'credit_group'  => $this->credit_group,
			'account'       => $this->account,
			'account_uuid'  => $this->account_uuid,
			'amount'        => $this->amount,
			'oauth_user_id' => $this->oauth_user_id,
			'ref'           => $this->ref,
			'created_at'    => $this->created_at,
			'updated_at'    => $this->updated_at,
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'credit_group',
			'tx_uuid',
			'account',
			'account_uuid',
			'amount',
			'oauth_user_id',
			'ref',
			'created_at',
			'updated_at',
		) );
	}
}
