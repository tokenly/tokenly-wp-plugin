<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaInterface as TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class PromiseMeta extends Post implements PromiseMetaInterface {
	public $promise_id;
	public $source_user_id;
	public $source_user;
	public $destination_user_id;
	public $destination_user;
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
		//Parent dependencies
		TcaSettingsInterface $tca_settings,
		TermServiceInterface $term_service,
		//Parent dependencides - end
		UserServiceInterface $user_service,
		PromiseMetaRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->user_service = $user_service;
		$this->domain_repository = $domain_repository;
		parent::__construct(
			$domain_repository,
			$tca_settings,
			$term_service,
			$data
		);
	}

	/**
	 * Loads the source user relation
	 * @param string[] $relations Further relations
	 * @return UserInterface 
	 */
	protected function load_source_user( array $relations = array() ) {
		$user = $this->user_service->show( array(
			'uuid' => $this->source_user_id,
			'with' => $relations,
		) );
		return $user;
	}

	/**
	 * Loads the destination user relation
	 * @param string[] $relations Further relations
	 * @return UserInterface
	 */
	protected function load_destination_user( array $relations = array() ) {
		$user = $this->user_service->show( array(
			'uuid' => $this->destination_user_id,
			'with' => $relations,
		) );
		return $user;
	}
}
