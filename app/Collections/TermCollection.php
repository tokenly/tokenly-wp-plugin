<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;

use Tokenly\Wp\Interfaces\Collections\TcaAccessReportCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaAccessReportCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class TermCollection extends Collection implements TermCollectionInterface {
	protected $item_type = TermInterface::class;
	protected $tca_access_collection_factory;

	public function __construct(
		TcaAccessReportCollectionFactoryInterface $tca_access_collection_factory,
		array $items
	) {
		parent::__construct( $items );
		$this->tca_access_collection_factory = $tca_access_collection_factory;
	}

	/**
	 * Tests if the specified user can pass all of the TCA rules
	 * of the terms in the collection
	 * @param UserInterface $user User to test
	 * @return TcaAccessReportCollectionInterface
	 */
	public function can_access( UserInterface $user ) {
		$access_reports = $this->tca_access_collection_factory->create();
		foreach ( ( array ) $this as $term ) {
			$access_report = $term->can_access_term( $user );
			$access_reports[] = $access_report;
		}
		return $access_reports;
	}
}
