<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;

class Promise extends Model implements PromiseInterface {
	public $source_id;
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
	public $promise_meta;
	protected $promise_meta_service;
	protected $promise_repository;
	protected $fillable = array(
		'source',
		'source_id',
		'destination',
		'asset',
		'quantity',
		'fingerprint',
		'txid',
		'created_at',
		'updated_at',
		'expiration',
		'ref',
		'pseudo',
		'note',
		'protocol',
		'chain',
		'promise_id',
		'promise_meta',
	);

	public function __construct(
		PromiseServiceInterface $domain_service,
		PromiseMetaServiceInterface $promise_meta_service,
		PromiseRepositoryInterface $promise_repository,
		array $data = array()
	) {
		$this->domain_service = $domain_service;
		$this->promise_meta_service = $promise_meta_service;
		$this->promise_repository = $promise_repository;
		parent::__construct( $data );
	}

	/**
	 * Associates promise meta with the promise
	 * @param PromiseMetaInterface $promise_meta_data Promise meta to associate
	 * @return self
	 */
	public function associate_meta( PromiseMetaInterface $promise_meta ) {
		$promise_meta->update( array(
			'promise_id' => $this->promise_id,
		) );
		$this->promise_meta = $promise_meta;
		return $this;
	}

	/**
	 * Destroys the existing promise
	 * @param integer $promise_id Tokenpass promise index
	 * @return void
	 */
	public function destroy() {
		if ( isset( $this->promise_meta ) ) {
			$this->promise_meta->destroy();	
		}
		$this->promise_repository->destroy( $this );
	}

	/**
	 * Loads the promise meta relation
	 * @param string[] $relations Further relations
	 * @return PromiseMetaInterface
	 */
	protected function load_promise_meta( array $relations ) {
		$promise_meta = $this->promise_meta_service->show( array(
			'with'        => $relations,
			'promise_ids' => array( $this->promise_id ), 
		) );
		return $promise_meta;
	}
}
