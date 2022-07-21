<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Models\Token\Address;

class Source extends Model implements SourceInterface {
	public ?string $address_id = null;
	public ?AddressInterface $address = null;
	public ?array $assets = null;
	public ?string $type = null;

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
			'address_id' => $this->address_id,
			'assets'     => $this->assets ?? array(),
			'type'       => $this->type,
		);
		if ( $this->address ) {
			$array['address'] = $this->address->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'address_id',
			'address',
			'assets',
			'type'
		) );
	}
}
