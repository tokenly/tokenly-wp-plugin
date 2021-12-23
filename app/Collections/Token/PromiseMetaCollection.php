<?php

/**
 * Collection of Promise meta objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;

class PromiseMetaCollection extends Collection implements PromiseMetaCollectionInterface {
	protected $item_type = PromiseMetaInterface::class;
	protected $meta_repository;

	public function __construct(
		array $items,
		PostMetaRepositoryInterface $meta_repository
	) {
		parent::__construct( $items );
		$this->meta_repository = $meta_repository;
	}
	
	public function key_by_promise_id() {
		$keyed = array();
		foreach ( (array) $this as $promise ) {
			$promise_id = $this->meta_repository->show( $promise->ID, 'promise_id' );
			$keyed[ $promise_id ] = $promise;
		}
		$this->exchangeArray( $keyed );
	}
}
