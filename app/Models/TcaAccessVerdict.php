<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaAccessVerdictInterface;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCheckResultCollectionInterface;

/**
 * Is used to sum up all of the TCA access decision logic and provide the result
 * with detailed information.
 */
class TcaAccessVerdict extends Model implements TcaAccessVerdictInterface {
	/**
	 * Access status. Allowed or not.
	 * @var bool
	 */
	public $status;
	/**
	 * Comment for the status.
	 * @var string
	 */
	public $note;
	/**
	 * Reports the decision was based on if any.
	 * @var TcaRuleCheckResultCollectionInterface
	 */
	public $reports;
	protected $fillable = array(
		'status',
		'note',
		'reports',
	);
}
