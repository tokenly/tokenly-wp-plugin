<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface;

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
	protected $source_service;
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
		PromiseMetaServiceInterface $promise_meta_service,
		PromiseRepositoryInterface $promise_repository,
		SourceServiceInterface $source_service,
		array $data = array()
	) {
		$this->domain_repository = $promise_repository;
		$this->promise_meta_service = $promise_meta_service;
		$this->source_service = $source_service;
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
	 * Destroys the promise
	 * @return void
	 */
	public function destroy() {
		if ( isset( $this->promise_meta ) && $this->promise_meta instanceof PromiseMetaInterface ) {
			$this->promise_meta->destroy();	
		}
		parent::destroy();
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

	/**
	 * Loads the source relation
	 * @param string[] $relations Further relations
	 * @return SourceInterface
	 */
	protected function load_source( array $relations ) {
		$source = $this->source_service->show( array(
			'address' => $this->source_id,
			'with'    => $relations,
		) );
		return $source;
	}
}
