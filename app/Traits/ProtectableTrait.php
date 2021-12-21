<?php

namespace Tokenly\Wp\Traits;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCheckResultCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaAccessVerdictFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

/**
 * Common logic for entities which can be protected by TCA.
 */
trait ProtectableTrait {
	/**
     * @Inject
     * @var TcaAccessVerdictFactoryInterface
     */
    private $tca_access_verdict_factory;
	/**
     * @Inject
     * @var TcaRuleCheckResultCollectionFactoryInterface
     */
    private $tca_rule_check_result_collection_factory;

	/**
	 * Begins the TCA check procedure
	 * @param UserInterface $user User to test
	 * @return TcaAccessVerdictInterface
	 */
	public function can_access( UserInterface $user ) {
		$verdict = null;
		$status = false;
		$note = '';
		$is_protected = $this->is_protected();
		if ( $is_protected === true ) {
			$precheck = $user->get_tca_precheck_data();
			if ( isset( $precheck['need_test'] ) && $precheck['need_test'] === true ) {
				$verdict = $this->test_access( $user );
				return $verdict;
			} else {
				if ( isset( $precheck['status'] ) ) {
					$status = $precheck['status'];
				}
				if ( isset( $precheck['note'] ) ) {
					$note = $precheck['note'];
				}
			}
		} else {
			$status = true;
		}
		$verdict = $this->tca_access_verdict_factory->create(
			array(
				'status'  => $status,
				'reports' => null,
				'note'    => $note,
			)
		);
		return $verdict;
	}

	/**
	 * Checks if any element of the item is protected by TCA
	 * @return bool
	 */
	public function is_protected() {
		$root_protected = $this->check_root_protected();
		$relations_protected = $this->check_relations_protected();
		if ( $root_protected === true || $relations_protected === true ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Gets all associated TCA rule groups
	 * @return array
	 */
	public function get_tca_rules() {
		$rules = array();
		$tca_enabled = $this->check_tca_enabled();
		if (
			$tca_enabled === true &&
			isset( $this->tca_rules ) &&
			$this->tca_rules instanceof TcaRuleCollectionInterface &&
			count( ( array ) $this->tca_rules ) > 0
		) {
			$rules[] = $this->tca_rules;
		}
		$relation_rules = $this->get_tca_rules_relation();
		$rules = array_merge( $rules, $relation_rules );
		$rules = $this->key_tca_rule_groups( $rules );
		return $rules;
	}

	/**
	 * Checks if the specified user can access the post and its terms
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access( UserInterface $user ) {
		$status = false;
		$reports = $this->tca_rule_check_result_collection_factory->create();
		$root_verdict = $this->test_access_root( $user );
		$relation_verdict = $this->test_access_relations( $user );
		if (
			$root_verdict->status === false ||
			$relation_verdict->status === false
		) {
			$status = false;
		} else {
			$status = true;
		}
		foreach ( array( $root_verdict, $relation_verdict ) as $verdict ) {
			if (
				$verdict instanceof TcaAccessVerdictInterface &&
				isset( $verdict->reports ) &&
				$verdict->reports instanceof TcaRuleCheckResultCollectionInterface
			) {
				$reports = $reports->merge( $verdict->reports );
			}
		}
		$verdict = $this->tca_access_verdict_factory->create( array(
			'status'  => $status,
			'reports' => $reports,
		) );
		return $verdict;
	}

	/**
	 * Checks if the specified user can access the post
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access_root( UserInterface $user ) {
		$need_test = true;
		$status = false;
		$reports = null;
		$tca_enabled = $this->check_tca_enabled();
		if ( $tca_enabled === false ) {
			$status = true;
			$need_test = false;
		}
		if ( $need_test === true ) {
			$result = $user->check_token_access( $this->tca_rules );
			$status = $result->status;
			$reports = $this->tca_rule_check_result_collection_factory->create( array( $result ) );
		}
		$verdict = $this->tca_access_verdict_factory->create( array(
			'status'  => $status,
			'reports' => $reports,
		) );
		return $verdict;
	}

	/**
	 * Test if the specified user is allowed to access the relations
	 * @param UserInterface $user User to test
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access_relations( UserInterface $user ) {
		$verdict = $this->tca_access_verdict_factory->create( array(
			'status'  => true,
			'reports' => null,
		) );
		return $verdict;
	}

	/**
	 * Gets the TCA rule groups of the relations
	 * @return array
	 */
	protected function get_tca_rules_relation() {
		return array();
	}

	/**
	 * Keys the TCA rule groups by their rule attribute hash
	 * @param array $rule_groups Rule groups to key
	 * @return array
	 */
	protected function key_tca_rule_groups( array $rule_groups ) {
		$rules_keyed = array();
		foreach ( $rule_groups as $rule ) {
			$rules_keyed[ $rule->to_hash() ] = $rule;
		}
		return $rules_keyed;
	}

	/**
	 * Checks if TCA is enabled for type
	 * @return bool
	 */
	protected function check_tca_enabled() {
		return false;
	}

	protected function check_root_protected() {
		$tca_enabled = $this->check_tca_enabled();
		$rules_total = 0;
		if ( isset( $this->tca_rules ) && $this->tca_rules instanceof TcaRuleCollectionInterface ) {
			$rules_total = count( ( array ) $this->tca_rules );
		}
		if ( $tca_enabled === true && $rules_total > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the relations are TCA protected
	 * @return bool
	 */
	protected function check_relations_protected() {
		return false;
	}
}
