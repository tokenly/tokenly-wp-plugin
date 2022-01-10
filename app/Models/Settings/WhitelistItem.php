<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistItemInterface;

class WhitelistItem extends Model implements WhitelistItemInterface {
	public $address = '';
	public $index = '';
	protected $fillable = array(
		'address',
		'index',
	);
	protected $casts = array(
		'address' => 'string',
		'index'   => 'string',
	);
}
