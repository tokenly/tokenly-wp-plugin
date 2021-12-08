<?php

/**
 * Collection of Promise objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;

class PromiseCollection extends Collection implements PromiseCollectionInterface {
	protected $item_type = PromiseInterface::class;
	protected $promise_meta_service;

	public function __construct(
		PromiseMetaServiceInterface $promise_meta_service,
		array $items
	) {
		parent::__construct( $items );
		$this->promise_meta_service = $promise_meta_service;
	}

	/**
	 * Loads the promise meta relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	// protected function load_promise_meta( array $relations ) {
	// 	$promise_ids = array_map( function( PromiseInterface $promise ) {
	// 		return $promise->promise_id;	
	// 	}, ( array ) $this );
	// 	$promises_meta = $this->promise_meta_service->index( array(
	// 		'with'        => $relations,
	// 		'promise_ids' => $promise_ids, 
	// 	) );
	// 	$promises_meta->key_by_promise_id();
	// 	foreach ( ( array ) $this as &$promise ) {
	// 		$promise_id = $promise->promise_id;
	// 		$promise->promise_meta = $promises_meta[ $promise_id ] ?? array();
	// 	}
	// 	return $this;
	// }
}
