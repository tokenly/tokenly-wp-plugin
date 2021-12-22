<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CreditAccountInterface;

class CreditAccount extends Model implements CreditAccountInterface {
	public $name;
	public $uuid;
	public $balance;
	public $oauth_user;
	public $created_at;
	public $updated_at;
	protected $fillable = array(
		'name',
		'uuid',
		'balance',
		'oauth_user',
		'created_at',
		'updated_at',
	);
}
