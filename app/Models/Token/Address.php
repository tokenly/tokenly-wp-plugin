<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;

use Tokenly\Wp\Collections\Token\BalanceCollection;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

class Address extends Model implements AddressInterface {
	protected ?string $address = null;
	protected ?BalanceCollectionInterface $balance = null;
	protected ?string $type = null;
	protected ?bool $public = null;
	protected ?string $label = null;
	protected ?bool $active = null;
	protected ?bool $verified = null;
	protected ?string $verify_code = null; 

	public function get_address(): ?string {
		return $this->address ?? null;
	}

	public function set_address( ?string $value ): void {
		$this->address = $value;
	}

	public function get_balance(): ?BalanceCollectionInterface {
		return $this->balance ?? null;
	}

	public function set_balance( ?BalanceCollectionInterface $value ): void {
		$this->balance = $value;
	}

	public function get_type(): ?string {
		return $this->type ?? null;
	}

	public function set_type( ?string $type ): void {
		$this->type = $type;
	}

	public function get_public(): ?bool {
		return $this->public ?? null;
	}

	public function set_public( ?bool $value ): void {
		$this->public = $value;
	}

	public function get_label(): ?string {
		return $this->label ?? null;
	}

	public function set_label( ?string $value ): void {
		$this->label = $value;
	}

	public function get_active(): ?bool {
		return $this->active ?? null;
	}

	public function set_active( ?bool $value ): void {
		$this->active = $value;
	}

	public function get_verified(): ?bool {
		return $this->verified ?? null;
	}

	public function set_verified( ?bool $value ): void {
		$this->verified = $value;
	}

	public function get_verify_code(): ?string {
		return $this->verify_code ?? null;
	}

	public function set_verify_code( ?string $value ): void {
		$this->verify_code = $value;
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
			'address'     => $this->get_address(),
			'type'        => $this->get_type(),
			'label'       => $this->get_label(),
			'public'      => $this->get_public(),
			'active'      => $this->get_active(),
			'verified'    => $this->get_verified(),
			'verify_code' => $this->get_verify_code(),
		);
		if ( $this->get_balance() ) {
			$array['balance'] = $this->get_balance()->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'address',
			'type',
			'label',
			'public',
			'active',
			'balance',
			'verified',
			'verify_code',
		) );
	}
}
