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
	public ?AssetInterface $asset = null;
	public ?string $name = '';
	public ?QuantityInterface $quantity = null;
	public ?int $precision = 0;
	public ?MetaInterface $meta = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		if ( isset( $data['quantity'] ) && is_array( $data['quantity'] ) ) {
			$data['quantity'] =
				( new Quantity() )->from_array( $data['quantity'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'name'      => $this->name,
			'precision' => $this->precision,
		);
		if ( $this->asset ) {
			$array['asset'] = $this->asset->to_array();
		}
		if ( $this->quantity ) {
			$array['quantity'] = $this->quantity->to_array();
		}
		if ( $this->meta ) {
			$array['meta'] = $this->meta->to_array();
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
