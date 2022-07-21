<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class Asset extends Model implements AssetInterface {
	public ?string $address = '';
	public ?string $index = '';

    public function __get( $name ) {
		switch ( $name ) {
			case "name":
				$this->get_name();
				break;
		}
    }

    public function __set( $name, $value ) {
		switch ( $name ) {
			case "name":
				$this->set_name( $value );
				break;
		}
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
			'address' => $this->address,
			'index'   => $this->index,
		);
		return $array;
	}

	/**
	 * Gets the Name ancestor
	 * @return string
	 */
	protected function get_name(): ?string {
		$address = $this->address;
		$index = $this->index;
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
	protected function set_name( string $value ): void {
		if ( strpos( $value, ':' ) !== false ) {
			$value = explode( ':', $value );
			$this->address = $value[0];
			$this->index = $value[1];
		} else {
			$this->address = $value;
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
