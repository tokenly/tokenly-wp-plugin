<?php

/**
 * Collection of TCA access reports
 */

namespace Tokenly\Wp\Collections\Token\Access;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCheckResultCollectionInterface;

use Tokenly\Wp\Models\Token\Access\RuleCheckResult;

class RuleCheckResultCollection extends Collection implements RuleCheckResultCollectionInterface {
	protected string $item_type = RuleCheckResult::class;

	/**
	 * Checks if the collection has any rule
	 * that didn't pass the tests
	 * @return bool
	 */
	public function can_pass() {
		foreach ( ( array ) $this as $report ) {
			if ( $report->status === false ) {
				return false;
			}
		}
		return true;
	}
}
