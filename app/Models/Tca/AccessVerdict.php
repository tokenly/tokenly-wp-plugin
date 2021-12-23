<?php

namespace Tokenly\Wp\Models\Tca;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Tca\AccessVerdictInterface;

use Tokenly\Wp\Interfaces\Collections\Tca\RuleCheckResultCollectionInterface;

/**
 * Is used to sum up all of the TCA access decision logic and provide the result
 * with detailed information.
 */
class AccessVerdict extends Model implements AccessVerdictInterface {
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
	 * @var RuleCheckResultCollectionInterface
	 */
	public $reports;
	protected $fillable = array(
		'status',
		'note',
		'reports',
	);
}
