<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistItemInterface;

use Tokenly\Wp\Models\Token\Asset;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class WhitelistItem extends Model implements WhitelistItemInterface {
	protected ?AssetInterface $asset = null;

	public function get_asset(): ?AssetInterface {
		return $this->asset ?? null;
	}

	public function set_asset( ?AssetInterface $value ): void {
		$this->asset = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array();
		if ( $this->get_asset() ) {
			$array['asset'] = $this->get_asset()->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'asset',
		) );
	}
}
