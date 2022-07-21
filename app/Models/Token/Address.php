<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;

use Tokenly\Wp\Collections\Token\BalanceCollection;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;

class Address extends Model implements AddressInterface {
	public ?string $address = null;
	public ?BalanceCollectionInterface $balance = null;
	public ?string $type = null;
	public ?bool $public = null;
	public ?string $label = null;
	public ?bool $active = null;
	public ?bool $verified = null;
	public ?string $verify_code = null; 

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
			'address'     => $this->address,
			'type'        => $this->type,
			'label'       => $this->label,
			'public'      => $this->public,
			'active'      => $this->active,
			'verified'    => $this->verified,
			'verify_code' => $this->verify_code,
		);
		if ( $this->balance ) {
			$array['balance'] = $this->balance->to_array();
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
