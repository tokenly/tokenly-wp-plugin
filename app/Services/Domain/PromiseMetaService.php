<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;

class PromiseMetaService implements PromiseMetaServiceInterface {
	protected $promise_meta_cache = array();
	protected $promise_meta_repository;
	protected $meta_repository;

	public function __construct(
		PromiseMetaRepositoryInterface $promise_meta_repository,
		MetaRepositoryInterface $meta_repository
	) {
		$this->promise_meta_repository = $promise_meta_repository;
		$this->meta_repository = $meta_repository;
	}

	public function get_promise_meta( int $id ) {
		$meta = $this->meta_repository->index( $id, array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
		return $meta;
	}
}



