<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;

class Promise implements PromiseInterface {
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

	public function __construct(
		$promise_data = array(),
		PromiseServiceInterface $promise_service,
		PromiseMetaServiceInterface $promise_meta_service
	) {
		$this->promise_service = $promise_service;
		$this->promise_meta_service = $promise_meta_service;
		$this->from_array( $promise_data );
	}

	public function from_array( $promise_data ) {
		$this->source = $promise_data['source'] ?? null;
		$this->destination = $promise_data['destination'] ?? null;
		$this->asset = $promise_data['asset'] ?? null;
		$this->quantity = $promise_data['quantity'] ?? null;
		$this->quantity_sat = $promise_data['quantity_sat'] ?? null;
		$this->fingerprint = $promise_data['fingerprint'] ?? null;
		$this->txid = $promise_data['txid'] ?? null;
		$this->created_at = $promise_data['created_at'] ?? null;
		$this->updated_at = $promise_data['updated_at'] ?? null;
		$this->expiration = $promise_data['expiration'] ?? null;
		$this->ref = $promise_data['ref'] ?? null;
		$this->pseudo = $promise_data['pseudo'] ?? null;
		$this->note = $promise_data['note'] ?? null;
		$this->protocol = $promise_data['protocol'] ?? null;
		$this->chain = $promise_data['chain'] ?? null;
		$this->promise_id = $promise_data['promise_id'] ?? null;
		$this->precision = $promise_data['precision'] ?? null;
		$this->promise_meta = $promise_data['promise_meta'] ?? null;
	}
	
	public function to_array() {
		$array = array(
			'source'       => $this->source,
			'destination'  => $this->destination,
			'asset'        => $this->asset,
			'quantity'     => $this->quantity,
			'fingerprint'  => $this->fingerprint,
			'txid'         => $this->txid,
			'created_at'   => $this->created_at,
			'updated_at'   => $this->updated_at,
			'expiration'   => $this->expiration,
			'ref'          => $this->ref,
			'pseudo'       => $this->pseudo,
			'note'         => $this->note,
			'protocol'     => $this->protocol,
			'chain'        => $this->chain,
			'promise_id'   => $this->promise_id,
			'precision'    => $this->precision, 
		);
		if ( isset( $this->promise_meta ) && is_a( $this->promise_meta, PromiseMetaInterface::class ) ) {
			$array['promise_meta'] = $this->promise_meta->to_array();
		}
		return $array;
	}

	public function update( $params = array() ) {
		$this->promise_service->update( $this->promise_id, $params );
	}

	/**
	 * Deletes the promise and its meta
	 */
	public function destroy() {
		if ( isset( $this->promise_meta ) && is_a( $this->promise_meta, PromiseMetaInterface::class ) ) {
			$this->promise_meta->destroy();	
		}
		$this->promise_service->destroy( $this->promise_id );
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
