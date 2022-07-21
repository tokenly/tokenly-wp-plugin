<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AssetNameFormatterServiceInterface;

class AssetNameFormatterService extends Service
	implements AssetNameFormatterServiceInterface {
	/**
	 * Splits the asset name on address and index
	 * @param string $value Asset name
	 * @return array
	 */
	public function split( string $value ): array {
		$address = null;
		$index = null;
		if ( $this->is_composite( $value ) ) {
			$value = explode( ':', $value );
			$address = $value[0];
			$index = $value[1];
		} else {
			$address = $value;
		}
		return array(
			'address' => $address,
			'index'   => $index,
		);
	}

	/**
	 * Combines Address and Index fields
	 * @param string $address Address
	 * @param string $index Index
	 * @return string
	 */
	public function combine( string $address, ?string $index ): ?string {
		$asset = $address;
		if ( $index && !empty( $index ) ) {
			$asset = "{$asset}:{$index}";
		}
		return $asset;
	}

	/**
	 * Checks if the asset name is composite
	 * @param string $value Asset name
	 * @return bool
	 */
	public function is_composite( string $value ): bool {
		return ( strpos( $value, ':' ) !== false );
	}
}
