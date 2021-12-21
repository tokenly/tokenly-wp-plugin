<?php

/**
 * Collection of Post objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;

use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaAccessVerdictFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCheckResultCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

class TermCollection extends Collection implements TermCollectionInterface {
	protected $item_type = TermInterface::class;
	protected $tca_rule_check_result_collection_factory;
	protected $tca_access_verdict_factory;
	protected $tca_rule_collection_factory;

	public function __construct(
		TcaRuleCheckResultCollectionFactoryInterface $tca_rule_check_result_collection_factory,
		TcaAccessVerdictFactoryInterface $tca_access_verdict_factory,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		array $items
	) {
		parent::__construct( $items );
		$this->tca_access_verdict_factory = $tca_access_verdict_factory;
		$this->tca_rule_check_result_collection_factory = $tca_rule_check_result_collection_factory;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
	}

	/**
	 * Gets TCA rules of all the terms in the collection
	 * @return array
	 */
	public function get_tca_rules() {
		$rules = array();
		foreach ( ( array ) $this as $term ) {
			$term_rules = $term->get_tca_rules();
			if ( $term_rules && is_array( $term_rules ) ) {
				$rules = array_merge( $rules, $term_rules );
			}
		}
		return $rules;
	}

	public function is_protected() {
		$results = array();
		foreach ( ( array ) $this as $term ) {
			$results[] = $term->is_protected();
		}
		if ( in_array( true, $results ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Tests if the specified user can pass all of the TCA rules
	 * of the terms in the collection
	 * @param UserInterface $user User to test
	 * @return TcaAccessVerdictInterface
	 */
	public function can_access( UserInterface $user ) {
		$status = false;
		$verdicts = array();
		foreach ( ( array ) $this as $term ) {
			$verdict = $term->can_access( $user );
			$verdicts[] = $verdict;
		}
		$statuses = array();
		foreach ( ( array ) $verdicts as $key => $verdict ) {
			$statuses[ $key ] = $verdict->status;
		}
		if ( in_array( false, $statuses ) ) {
			$status = false;
		} else {
			$status = true;
		}
		$reports = $this->tca_rule_check_result_collection_factory->create();
		foreach ( $verdicts as $verdict ) {
			if ( isset( $verdict->reports ) && $verdict->reports instanceof TcaRuleCheckResultCollectionInterface )
			$reports = $reports->merge( $verdict->reports );
		}
		$verdict = $this->tca_access_verdict_factory->create(
			array(
				'status'  => $status,
				'reports' => $reports,
			)
		);
		return $verdict;
	}
}
