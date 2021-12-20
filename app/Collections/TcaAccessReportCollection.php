<?php

/**
 * Collection of TCA access reports
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TcaAccessReportCollectionInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessReportnterface;

class TcaAccessReportCollection extends Collection implements TcaAccessReportCollectionInterface {
	protected $item_type = TcaAccessReportnterface::class;

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
