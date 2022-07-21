<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\CheckerServiceInterface;

use Tokenly\Wp\Collections\Token\Access\RuleCheckResultCollection;
use Tokenly\Wp\Collections\Token\Access\RuleCollectionCollection;
use Tokenly\Wp\Models\Token\Access\Verdict;
use Tokenly\Wp\Models\Token\Access\RuleCheckResult;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionCollectionInterface;
use Tokenly\Wp\Interfaces\Models\ModelInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Token\Access\VerdictInterface;
use Tokenly\Wp\Interfaces\Models\Token\Access\RuleCheckResultInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class CheckerService extends Service implements CheckerServiceInterface {
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected TcaSettingsInterface $tca_settings;
	protected UserRepositoryInterface $user_repository;
	protected TokenpassAPIInterface $client;

	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		UserRepositoryInterface $user_repository,
		TokenpassAPIInterface $client
	) {
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->user_repository = $user_repository;
		$this->client = $client;
	}

	/**
	 * Begins the TCA check procedure
	 * @param object|null $target Access target
	 * @param UserInterface $user User to test
	 * @return VerdictInterface Access verdict
	 */
	public function check(
		ProtectableInterface $target,
		?UserInterface $user = null
	): VerdictInterface {
		$verdict;
		if ( $target instanceof CollectionInterface ) {
			$verdict =  $this->check_collection( $target, $user );
		} elseif ( $target instanceof ModelInterface ) {
			$verdict = $this->check_single( $target, $user );
		}
		return $verdict;
	}

	protected function check_single(
		ProtectableInterface $target,
		?UserInterface $user = null
	): VerdictInterface {
		$verdict = null;
		$status = false;
		$note = '';
		$is_protected = $this->is_protected( $target );
		if ( $is_protected === true ) {
			if ( $user ) {
				$precheck = $this->get_user_precheck_data( $user );
				if (
					isset( $precheck['need_test'] ) &&
					$precheck['need_test'] === true
				) {
					$verdict = $this->test_access( $target, $user );
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
				$status = false;
				$need_test = false;
				$note = 'The user is not logged in.';
			}
		} else {
			$status = true;
		}
		$verdict = new Verdict(
			array(
				'status'  => $status,
				'reports' => null,
				'note'    => $note,
			)
		);
		return $verdict;
	}
	
	protected function check_collection(
		ProtectableInterface $target,
		?UserInterface $user = null
	): VerdictInterface {
		$status = false;
		$verdicts = array();
		foreach ( ( array ) $target as $item ) {
			$verdict = $this->check( $item, $user );
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
		$reports = new RuleCheckResultCollection();
		foreach ( $verdicts as $verdict ) {
			if ( $verdict->reports ) {
				$reports = $reports->merge( $verdict->reports );
			}
		}
		$verdict = new Verdict(
			array(
				'status'  => $status,
				'reports' => $reports,
			)
		);
		return $verdict;
	}

	/**
	 * Checks if any element of the item is protected by TCA
	 * @return bool
	 */
	public function is_protected( ProtectableInterface $target ): bool {
		$protected = false;
		if ( $target instanceof CollectionInterface ) {
			$protected = $this->is_protected_collection( $target );
		} elseif ( $target instanceof ModelInterface ) {
			$protected = $this->is_protected_single( $target );
		}
		return $protected;
	}

	protected function is_protected_single(
		ProtectableInterface $target
	): bool {
		$protected = false;
		$root_protected = $this->check_root_protected( $target );
		$relations_protected = $this->check_relations_protected( $target );
		if ( $root_protected === true || $relations_protected === true ) {
			$protected = true;
		} else {
			$protected = false;
		}
		return $protected;
	}

	protected function is_protected_collection(
		ProtectableInterface $target
	): bool {
		$protected = false;
		$results = array();
		foreach ( ( array ) $target as $item ) {
			$results[] = $this->is_protected( $item );
		}
		if ( in_array( true, $results ) ) {
			$protected = true;
		} else {
			$protected = false;
		}
		return $protected;
	}

	/**
	 * Gets all associated TCA rule groups
	 * @return array
	 */
	public function get_tca_rules(
		ProtectableInterface $target
	): RuleCollectionCollectionInterface {
		$rules = new RuleCollectionCollection();
		if ( $target instanceof CollectionInterface ) {
			$rules = $this->get_tca_rules_collection( $target );
		} elseif ( $target instanceof ModelInterface ) {
			$rules = $this->get_tca_rules_single( $target );
		}
		return $rules;
	}

	protected function get_tca_rules_single(
		ModelInterface $target
	): RuleCollectionCollectionInterface {
		$rules = new RuleCollectionCollection();
		$tca_enabled = $this->check_tca_enabled( $target );
		if (
			$tca_enabled === true &&
			$target->tca_rules &&
			count( ( array ) $target->tca_rules ) > 0
		) {
			$root_rules = $target->tca_rules;
			if ( $root_rules ) {
				$rules[] = $root_rules;
			}
		}
		$relation_rules = $this->get_tca_rules_relation( $target );
		if ( $relation_rules ) {
			$rules->merge( $relation_rules );
		}
		$rules->key_by_hash();
		return $rules;
	}

	protected function get_tca_rules_collection(
		CollectionInterface $target
	): RuleCollectionCollectionInterface {
		$rules = new RuleCollectionCollection();
		foreach ( $target as $target_item ) {
			$item_rules = $this->get_tca_rules_single( $target_item );
			if ( $item_rules ) {
				$rules->merge( $relation_rules );
			}
		}
		return $rules;
	}

	/**
	 * Gets the TCA rule groups of the relations
	 * @return array
	 */
	protected function get_tca_rules_relation(
		ProtectableInterface $target
	): RuleCollectionCollectionInterface {
		return new RuleCollectionCollection();
	}

	/**
	 * Checks if the user can pass TCA check with
	 * the specified rules
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param RuleCollectionInterface $rules Rules to use
	 * @return RuleCheckResultInterface|null
	 */
	public function check_token_access(
		OauthUserInterface $oauth_user,
		RuleCollectionInterface $rules
	): RuleCheckResultInterface {
		$username = $oauth_user->username;
		$oauth_token = $oauth_user->oauth_token;
		$rules_formatted = $rules->format_rules();
		$status = boolval( $this->client->checkTokenAccess(
			$username,
			$rules_formatted,
			$oauth_token
		) ) ?? false;
		$report = new RuleCheckResult ( array(
			'hash'   => $rules->to_hash(),
			'status' => $status,
		) );
		return $report;
	}

	/**
	 * Checks if the specified user can access the post and its terms
	 * @param UserInterface $user User to check
	 * @return VerdictInterface
	 */
	protected function test_access(
		ProtectableInterface $target,
		?UserInterface $user = null
	): VerdictInterface {
		$status = false;
		$reports = new RuleCheckResultCollection();
		$root_verdict = $this->test_access_root( $target, $user );
		$relation_verdict = $this->test_access_relations( $target, $user );
		if (
			$root_verdict->status === false ||
			$relation_verdict->status === false
		) {
			$status = false;
		} else {
			$status = true;
		}
		foreach ( array( $root_verdict, $relation_verdict ) as $verdict ) {
			if ( $verdict && $verdict->reports ) {
				$reports = $reports->merge( $verdict->reports );
			}
		}
		$verdict = new Verdict( array(
			'status'  => $status,
			'reports' => $reports,
		) );
		return $verdict;
	}

	/**
	 * Checks if the specified user can access the post
	 * @param UserInterface $user User to check
	 * @return VerdictInterface
	 */
	protected function test_access_root(
		ProtectableInterface $target,
		?UserInterface $user = null
	): VerdictInterface {
		$need_test = true;
		$status = false;
		$reports = null;
		$tca_enabled = $this->check_tca_enabled( $target );
		if ( $tca_enabled === false ) {
			$status = true;
			$need_test = false;
		}
		if ( $need_test === true ) {
			$user = $this->user_repository->load(
				$user, array( 'oauth_user' )
			);
			$result = null;
			if ( $user->oauth_user && $target->tca_rules ) {
				$result = $this->check_token_access(
					$user->oauth_user,
					$target->tca_rules
				);
				$status = $result->status;
				$reports = new RuleCheckResultCollection( array( $result ) );
			}
		}
		$verdict = new Verdict( array(
			'status'  => $status,
			'reports' => $reports,
		) );
		return $verdict;
	}

	/**
	 * Test if the specified user is allowed to access the relations
	 * @param UserInterface $user User to test
	 * @return VerdictInterface|null
	 */
	protected function test_access_relations(
		ProtectableInterface $target,
		?UserInterface $user = null
	): ?VerdictInterface {
		$verdict = new Verdict( array(
			'status'  => true,
			'reports' => null,
		) );
		return $verdict;
	}

	/**
	 * Checks if TCA is enabled for type
	 * @return bool
	 */
	protected function check_tca_enabled(
		ProtectableInterface $target
	): bool {
		return false;
	}

	protected function check_root_protected(
		ProtectableInterface $target
	): bool {
		$tca_enabled = $this->check_tca_enabled( $target );
		$rules_total = 0;
		if ( $target->get_tca_rules() ) {
			$rules_total = count( ( array ) $target->get_tca_rules() );
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
	protected function check_relations_protected(
		ProtectableInterface $target
	): bool {
		return false;
	}

	/**
	 * Tests the user before starting TCA check
	 * @return array
	 */
	protected function get_user_precheck_data(
		?UserInterface $user = null
	): array {
		$status = false;
		$note = '';
		$need_test = true;
		if ( $user ) {
			if ( user_can( $user, 'administrator' ) ) {
				$status = true;
				$need_test = false;
			} else {
				$user = $this->user_repository->load(
					$user,
					array( 'oauth_user' )
				);
				if ( !$user->oauth_user ) {
					$status = false;
					$need_test = false;
					$note = 'The user is not connected.';
				}
			}
		}
		return array(
			'need_test' => $need_test,
			'status'    => $status,
			'note'      => $note,
		);
	}
}
