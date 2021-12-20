<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaAccessReportInterface;

class TcaAccessReport extends Model implements TcaAccessReportInterface {
	public $hash;
	public $status;
	protected $fillable = array(
		'hash',
		'status',
	);
}
