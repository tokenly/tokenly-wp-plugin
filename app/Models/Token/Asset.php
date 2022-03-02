<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class Asset extends Model implements AssetInterface {
	protected ?string $address = '';
	protected ?string $index = '';

	/**
	 * Gets the Address property
	 * @return string
	 */
	public function get_address(): ?string {
		return $this->address ?? null;
	}

	/**
	 * Sets the Address property
	 * @param string $value New value
	 * @return void
	 */
	public function set_address( ?string $value ): void {
		$this->address = $value;
	}

	/**
	 * Gets the Index property
	 * @return string
	 */
	public function get_index(): ?string {
		return $this->index ?? null;
	}

	/**
	 * Sets the Index property
	 * @param string $value New value
	 * @return void
	 */
	public function set_index( ?string $value ): void {
		$this->index = $value;
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
			'address' => $this->get_address(),
			'index'   => $this->get_index(),
		);
		return $array;
	}

	/**
	 * Gets the Name ancestor
	 * @return string
	 */
	public function get_name(): ?string {
		$address = $this->get_address();
		$index = $this->get_index();
		$asset = $address;
		if ( isset( $index ) && !empty( $index ) ) {
			$asset = "{$asset}:{$index}";
		}
		return $asset;
	}

	/**
	 * Sets the Name ancestor
	 * @param string $value New name
	 * @return void
	 */
	public function set_name( string $value ): void {
		if ( strpos( $value, ':' ) !== false) {
			$value = explode( ':', $value );
			$this->set_address( $value[0] );
			$this->set_index( $value[1] );
		} else {
			$this->set_address( $value );
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'address',
			'index',
		) );
	}
}
