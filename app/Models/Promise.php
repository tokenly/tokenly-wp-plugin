<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;

class Promise implements PromiseInterface {
	public $source;
	public $destination;
	public $asset;
	public $quantity;
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
	protected $promise_repository;

	public function __construct(
		$promise_data = array(),
		PromiseRepositoryInterface $promise_repository
	) {
		$this->promise_repository = $promise_repository;
		$this->from_array( $promise_data );
	}

	public function from_array( $promise_data ) {
		$this->source = $promise_data['source'] ?? null;
		$this->destination = $promise_data['destination'] ?? null;
		$this->asset = $promise_data['asset'] ?? null;
		$this->quantity = $promise_data['quantity'] ?? null;
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
	}

	public function update( $params = array() ) {
		$this->promise_repository->update( $this->promise_id, $params );
	}

	public function destroy() {
		$this->promise_repository->destroy( $this->promise_id );
	}
}
