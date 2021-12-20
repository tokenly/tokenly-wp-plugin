<?php

/**
 * Collection of TCA access reports
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TcaRuleCheckResultInterface;

class TcaRuleCheckResultCollection extends Collection implements TcaRuleCheckResultCollectionInterface {
	protected $item_type = TcaRuleCheckResultInterface::class;

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
