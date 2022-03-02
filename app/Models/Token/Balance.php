<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;

use Tokenly\Wp\Models\Token\Asset;
use Tokenly\Wp\Models\Token\Quantity;
use Tokenly\Wp\Models\Token\Meta;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

class Balance extends Model implements BalanceInterface {
	protected ?AssetInterface $asset = null;
	protected ?string $name = '';
	protected ?QuantityInterface $quantity = null;
	protected ?int $precision = 0;
	protected ?MetaInterface $meta = null;

	/**
	 * Gets the Asset property
	 * @return AssetInterface|null
	 */
	public function get_asset(): ?AssetInterface {
		return $this->asset ?? null;
	}

	/**
	 * Sets the Asset property
	 * @param AssetInterface $value New value
	 * @return void
	 */
	public function set_asset( ?AssetInterface $value ): void {
		$this->asset = $value;
	}

	public function get_name(): ?string {
		return $this->name ?? null;
	}

	public function set_name( ?string $value ): void {
		$this->name = $value;
	}

	public function get_quantity(): ?QuantityInterface {
		return $this->quantity ?? null;
	}

	public function set_quantity( ?QuantityInterface $value ): void {
		$this->quantity = $value;
	}

	public function get_precision(): ?int {
		return $this->precision ?? null;
	}

	public function set_precision( ?int $value ): void {
		$this->precision = $value;
	}

	public function get_meta(): ?MetaInterface {
		return $this->meta ?? null;
	}

	public function set_meta( ?MetaInterface $value ): void {
		$this->meta = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		if ( isset( $data['quantity'] ) && is_array( $data['quantity'] ) ) {
			$data['quantity'] = ( new Quantity() )->from_array( $data['quantity'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'name'      => $this->get_name(),
			'precision' => $this->get_precision(),
		);
		if ( $this->get_asset() ) {
			$array['asset'] = $this->get_asset()->to_array();
		}
		if ( $this->get_quantity() ) {
			$array['quantity'] = $this->get_quantity()->to_array();
		}
		if ( $this->get_meta() ) {
			$array['meta'] = $this->get_meta()->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'asset',
			'name',
			'quantity',
			'precision',
		) );
	}
}
