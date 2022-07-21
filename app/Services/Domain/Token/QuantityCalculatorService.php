<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Domain\Token\QuantityCalculatorServiceInterface;

class QuantityCalculatorService extends Service
	implements QuantityCalculatorServiceInterface {
	/**
	 * Applies precision to the Satoshi equivalent
	 * @param float $value Satoshi equivalent
	 * @param int $precision Precision
	 * @return float
	 */
	public function from_sat( float $value, int $precision = 1 ): float {
		if ( $precision == 0 ) {
			return $value;
		}
		$divisor = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value / $divisor;
		return $value;
	}

	/**
	 * Converts the value to Satoshi equivalent
	 * @param float $value Value
	 * @param int $precision Precision
	 * @return float
	 */
	public function to_sat( float $value, int $precision = 0 ): float {
		if ( $precision == 0 ) {
			return $value;
		}
		$multiplier = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value * $multiplier;
		return $value;
	}
}
