<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\WhitelistItemInterface;

use Tokenly\Wp\Models\Token\Asset;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class WhitelistItem extends Model implements WhitelistItemInterface {
	public ?AssetInterface $asset = null;

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
		if ( $this->asset ) {
			$array['asset'] = $this->asset->to_array();
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
