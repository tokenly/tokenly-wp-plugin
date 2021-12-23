<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface;

class Group extends Model implements GroupInterface {
	public $name;
	public $uuid;
	public $active;
	public $app_whitelist;
	public $created_at;
	public $updated_at;
	protected $fillable = array(
		'name',
		'uuid',
		'active',
		'app_whitelist',
		'created_at',
		'updated_at',
	);

	public function __construct(
		CreditGroupRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		parent::__construct( $data );
	}

}
