<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionInterface;

class Transaction extends Model implements TransactionInterface {
	protected ?string $tx_uuid = null;
	protected ?string $credit_group = null;
	protected ?string $account = null;
	protected ?string $account_uuid = null;
	protected ?float $amount = null;
	protected ?string $oauth_user_id = null;
	protected ?string $ref = null;
	protected ?string $created_at = null;
	protected ?string $updated_at = null;

	public function get_tx_uuid(): ?string {
		return $this->tx_uuid ?? null;
	}

	public function set_tx_uuid( ?string $value ): void {
		$this->tx_uuid = $value;
	}

	public function get_credit_group(): ?string {
		return $this->credit_group ?? null;
	}

	public function set_credit_group( ?string $value ): void {
		$this->credit_group = $value;
	}

	public function get_account_uuid(): ?string {
		return $this->account_uuid ?? null;
	}

	public function set_account_uuid( ?string $value ): void {
		$this->account_uuid = $value;
	}

	public function get_account(): ?string {
		return $this->account ?? null;
	}

	public function set_account( ?string $value ): void {
		$this->account = $value;
	}

	public function get_amount(): ?float {
		return $this->amount ?? null;
	}

	public function set_amount( ?float $value ): void {
		$this->amount = $value;
	}

	public function get_oauth_user_id(): ?string {
		return $this->oauth_user_id ?? null;
	}

	public function set_oauth_user_id( ?string $value ): void {
		$this->oauth_user_id = $value;
	}

	public function get_ref(): ?string {
		return $this->ref ?? null; 
	}

	public function set_ref( ?string $value ): void {
		$this->ref = $value;
	}

	public function get_created_at(): ?string {
		return $this->created_at ?? null;
	}

	public function set_created_at( ?string $value ): void {
		$this->created_at = $value;
	}

	public function get_updated_at(): ?string {
		return $this->updated_at ?? null;
	}

	public function set_updated_at( ?string $value ): void {
		$this->updated_at = $value;
	}

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
			'tx_uuid'       => $this->get_tx_uuid(),
			'credit_group'  => $this->get_credit_group(),
			'account'       => $this->get_account(),
			'account_uuid'  => $this->get_account_uuid(),
			'amount'        => $this->get_amount(),
			'oauth_user_id' => $this->get_oauth_user_id(),
			'ref'           => $this->get_ref(),
			'created_at'    => $this->get_created_at(),
			'updated_at'    => $this->get_updated_at(),
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
