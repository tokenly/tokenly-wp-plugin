<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;

class Account extends Model implements AccountInterface {
	public $name;
	public $uuid;
	public $balance;
	public $oauth_user;
	public $created_at;
	public $updated_at;
	public $group;
	protected $fillable = array(
		'name',
		'uuid',
		'balance',
		'oauth_user',
		'created_at',
		'updated_at',
		'group',
	);
}
