<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface;

use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface;

class Balance extends Model implements BalanceInterface {
	public $asset;
	public $name;
	public $quantity;
	public $precision;
	public $token_meta;
	protected $meta_service;
	protected $fillable = array(
		'asset',
		'name',
		'quantity',
		'token_meta',
	);

	public function __construct(
		MetaServiceInterface $meta_service,
		array $data = array()
	) {
		$this->meta_service = $meta_service;
		parent::__construct( $data );
	}

	/**
	 * Loads the token_meta relation
	 * @param string[] $relations Further relations
	 * @return MetaInterface
	 */
	protected function load_token_meta( array $relations ) {
		$token_meta = $this->meta_service->show( array(
			'assets' => array( $this->asset ),
			'with'   => $relations,
		) );
		return $token_meta;
	}
}
