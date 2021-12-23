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
