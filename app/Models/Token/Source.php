<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Models\Token\Address;

class Source extends Model implements SourceInterface {
	protected ?string $address_id = null;
	protected ?AddressInterface $address = null;
	protected ?array $assets = null;
	protected ?string $type = null;

	public function get_address_id(): ?string {
		return $this->address_id ?? null;
	}

	public function set_address_id( ?string $value ): void {
		$this->address_id = $value;
	}

	public function get_address(): ?AddressInterface {
		return $this->address ?? null;
	}

	public function set_address( ?AddressInterface $value ): void {
		$this->address = $value;
	}

	public function get_assets(): ?array {
		return $this->assets ?? null;
	}

	public function set_assets( ?array $value ): void {
		$this->assets = $value;
	}

	public function get_type(): ?string {
		return $this->type ?? null;
	}

	public function set_type( ?string $value ): void {
		$this->type = $value;
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
			'address_id' => $this->get_address_id(),
			'assets'     => $this->get_assets() ?? array(),
			'type'       => $this->get_type(),
		);
		if ( $this->get_address() ) {
			$array['address'] = $this->get_address()->to_array();
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
