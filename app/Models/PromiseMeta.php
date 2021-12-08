<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;

class PromiseMeta extends Model implements PromiseMetaInterface {
	public $promise_id;
	public $source_user_id;
	public $source_user;
	public $destination_user_id;
	public $destination_user;
	public $post;
	protected $user_service;
	protected $fillable = array(
		'post',
		'promise_id',
		'promise',
		'source_user_id',
		'source_user',
		'destination_user_id',
		'destination_user',
	);

	public function __construct(
		UserServiceInterface $user_service,
		PromiseMetaRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->user_service = $user_service;
		$this->domain_repository = $domain_repository;
		parent::__construct( $data );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->post, $method ), $args );
	}

	public function __get( $key ) {
		return $this->post->$key;
	}

	public function __set( $key, $val ) {
		return $this->post->$key = $val;
	}

	protected function load_source_user( array $relations ) {
		$user = $this->user_service->show( array(
			'uuid' => $this->source_user_id,
			'with' => $relations,
		) );
		$this->source_user = $user;
		return $this;
	}

	protected function load_destination_user( array $relations ) {
		$user = $this->user_service->show( array(
			'uuid' => $this->destination_user_id,
			'with' => $relations,
		) );
		$this->destination_user = $user;
		return $this;
	}
}
