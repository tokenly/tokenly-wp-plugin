<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;

class Promise extends Model implements PromiseInterface {
	public $source;
	public $destination;
	public $asset;
	public $quantity;
	public $quantity_sat;
	public $fingerprint;
	public $txid;
	public $created_at;
	public $updated_at;
	public $expiration;
	public $ref;
	public $pseudo;
	public $note;
	public $protocol;
	public $chain;
	public $promise_id;
	public $precision;
	public $promise_meta;
	protected $promise_meta_service;
	protected $fillable = array(
		'source',
		'destination',
		'asset',
		'quantity',
		'quantity_sat',
		'fingerprint',
		'txid',
		'created_at',
		'expiration',
		'ref',
		'pseudo',
		'note',
		'protocol',
		'chain',
		'promise_id',
		'precision',
		'promise_meta',
	);

	public function __construct(
		PromiseServiceInterface $domain_service,
		PromiseMetaServiceInterface $promise_meta_service,
		array $data = array()
	) {
		$this->domain_service = $domain_service;
		$this->promise_meta_service = $promise_meta_service;
		parent::__construct( $data );
	}

	public function update( $params = array() ) {
		$this->domain_service->update( $this->promise_id, $params );
	}

	/**
	 * Deletes the promise and its meta
	 */
	public function destroy() {
		if ( isset( $this->promise_meta ) && is_a( $this->promise_meta, PromiseMetaInterface::class ) ) {
			$this->promise_meta->destroy();	
		}
		$this->domain_service->destroy( $this->promise_id );
	}

	/**
	 * Adds promise meta post to the promise
	 * @param array $promise_meta_data New promise meta data
	 * @return PromiseMetaInterface
	 */
	public function add_meta( array $promise_meta_data ) {
		$promise_meta_data['promise_id'] = $this->promise_id;
		$promise_meta = $this->promise_meta_service->store( $promise_meta_data );
		if ( !$promise_meta ) {
			return false;
		}
		$this->promise_meta = $promise_meta;
		return $promise_meta;
	}
}

// if ( isset( $data['quantity'] ) && isset( $data['precision'] ) ) {
// 	$quantity = $data['quantity'] ?? null;
// 	$precision = $data['precision'] ?? null;
// 	if ( $precision > 0 ) {
// 		$divisor = intval( 1 . str_repeat( 0, $precision ) );
// 		$quantity = $quantity / $divisor;
// 		$data['quantity'] = $quantity;
// 	}
// }
