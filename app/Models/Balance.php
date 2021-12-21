<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;

class Balance extends Model implements BalanceInterface {
	public $asset;
	public $name;
	public $quantity;
	public $precision;
<<<<<<< HEAD
	public $token_meta;
	protected $token_meta_service;
	protected $fillable = array(
		'asset',
		'name',
		'quantity',
		'token_meta',
	);

	public function __construct(
		TokenMetaServiceInterface $token_meta_service,
		array $data = array()
	) {
		$this->token_meta_service = $token_meta_service;
		parent::__construct( $data );
=======
	public $meta;

	public function __construct(
		array $balance_data
	) {
		$this->from_array( $balance_data );
	}

	public function to_array() {
		$array = array(
			'asset'       => $this->asset,
			'name'        => $this->name,
			'balance'     => $this->balance,
			'balance_sat' => $this->balance_sat,
			'precision'   => $this->precision,
		);
		if ( isset( $this->meta ) ) {
			$array['meta'] = $this->meta->to_array();
		}
		return $array;
	}

	protected function from_array( $balance_data ) {
		if ( isset( $balance_data['asset'] ) ) {
			$this->asset = $balance_data['asset'] ?? null;
		}
		if ( isset( $balance_data['name'] ) ) {
			$this->name = $balance_data['name'] ?? null;
		}
		if ( isset( $balance_data['balance'] ) ) {
			$this->balance = floatval( $balance_data['balance'] ?? null );
		}
		if ( isset( $balance_data['balance_sat'] ) ) {
			$this->balance_sat = floatval( $balance_data['balance_sat'] ?? null );
		}
		if ( isset( $balance_data['precision'] ) ) {
			$this->precision = intval( $balance_data['precision'] ?? null );
		}
		if (
			isset( $this->balance ) === false &&
			isset( $this->balance_sat ) == true &&
			isset( $this->precision ) === true
		) {
			$this->balance = $this->from_sat( $this->balance_sat, $this->precision );
		}
>>>>>>> main
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
