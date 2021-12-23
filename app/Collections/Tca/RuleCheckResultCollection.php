<?php

/**
 * Collection of TCA access reports
 */

namespace Tokenly\Wp\Collections\Tca;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Tca\RuleCheckResultCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Tca\RuleCheckResultInterface;

class RuleCheckResultCollection extends Collection implements RuleCheckResultCollectionInterface {
	protected $item_type = RuleCheckResultInterface::class;

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
