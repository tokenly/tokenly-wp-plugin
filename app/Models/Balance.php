<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

class Balance extends Model implements BalanceInterface {
	public $asset;
	public $name;
	public $balance;
	public $balance_sat;
	public $precision;
	public $token_meta;
	protected $token_meta_service;
	protected $fillable = array(
		'asset',
		'name',
		'balance',
		'balance_sat',
		'precision',
		'token_meta',
	);

	public function __construct(
		TokenMetaServiceInterface $token_meta_service,
		array $data = array()
	) {
		$this->token_meta_service = $token_meta_service;
		parent::__construct( $data );
	}

	public function fill( array $data ) {
		parent::fill( $data );
		if ( 
			isset( $this->balance ) === false && 
			isset( $this->balance_sat ) == true && 
			isset( $this->precision ) === true
		) {
			$this->balance = $this->from_sat( $this->balance_sat, $this->precision );
		}
	}

	public function from_sat( $value, $precision = 1 ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$divisor = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value / $divisor;
		return $value;
	}

	public function to_sat( $value, $precision ) {
		if ( $precision == 0 ) {
			return $value;
		}
		$multiplier = intval( 1 . str_repeat( 0, $precision ) );
		$value = $value * $divisor;
		return $value;
	}

	/**
	 * Loads the token meta relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_token_meta( array $relations ) {
		$token_meta = $this->token_meta_service->show( array(
			'assets' => array( $this->asset ),
			'with'   => $relations,
		) );
		if ( $token_meta ) {
			$this->token_meta = $token_meta;
		}
		return $this;
	}
}
