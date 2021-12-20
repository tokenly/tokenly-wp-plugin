<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;

use Tokenly\Wp\Interfaces\Collections\TcaAccessReportCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCheckResultCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaAccessVerdictFactoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessReportInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class Post extends Model implements PostInterface {
	public $tca_rules;
	public $term;
	protected $post = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $tca_access_verdict_factory;
	protected $tca_rule_check_result_collection_factory;
	protected $tca_rule_collection_factory;
	protected $term_service;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostRepositoryInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaAccessVerdictFactoryInterface $tca_access_verdict_factory,
		TcaRuleCheckResultCollectionFactoryInterface $tca_rule_check_result_collection_factory,
		TcaSettingsInterface $tca_settings,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		TermServiceInterface $term_service,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
		$this->tca_access_verdict_factory = $tca_access_verdict_factory;
		$this->tca_rule_check_result_collection_factory = $tca_rule_check_result_collection_factory;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
		$this->term_service = $term_service;
		parent::__construct( $data );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->post, $method ), $args );
	}

	public function __get( $key ) {
		return $this->post->$key;
	}

	public function __set( $key, $val ) {
		return $this->post->$key = $val;
	}

	/**
	 * Main pipeline for post access check
	 * @param int $post_id ID of the post to check
	 * @param UserInterface $user User to check
	 * @return array
	 */
	public function can_access_post( UserInterface $user ) {
		$precheck = $user->get_tca_precheck_data();
		$verdict = null;
		if ( $precheck['need_test'] === true ) {
			$verdict = $this->test_access( $user );
		} else {
			$verdict = $precheck['verdict'];
		}
		return $verdict;
	}

	public function get_all_tca_rules() {
		$rules = array();
		if ( isset( $this->tca_rules ) && $this->tca_rules instanceof TcaRuleCollectionInterface ) {
			$rules[] = $this->tca_rules;
		}
		$this->load( array( 'term' ) );
		if ( isset( $this->term ) && $this->term instanceof TermCollectionInterface ) {
			$term_rules = $this->term->get_all_tca_rules();
			if ( $term_rules && $term_rules instanceof TcaRuleCollectionInterface ) {
				$rules[] = $term_rules;
			}
		}
		$rules_keyed = array();
		foreach ( $rules as $rule ) {
			$rules_keyed[ $rule->to_hash() ] = $rule;
		}
		return $rules_keyed;
	}

	/**
	 * Checks if the specified user can access the post and its terms
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access( UserInterface $user ) {
		$status = false;
		$reports = $this->tca_rule_check_result_collection_factory->create();
		$term_verdict = $this->test_access_terms( $user );
		$post_verdict = $this->test_access_post( $user );
		if (
			$term_verdict->status === false ||
			$post_verdict->status === false
		) {
			$status = false;
		} else {
			$status = true;
		}
		if (
			$term_verdict instanceof TcaAccessVerdictInterface &&
			isset( $term_verdict->reports ) &&
			$term_verdict->reports instanceof TcaRuleCheckResultCollectionInterface
		) {
			$reports = $reports->merge( $term_verdict->reports );
		}
		if (
			$post_verdict instanceof TcaAccessVerdictInterface &&
			isset( $post_verdict->reports ) &&
			$post_verdict->reports instanceof TcaRuleCheckResultCollectionInterface
		) {
			$reports = $reports->merge( $post_verdict->reports );
		}
		$verdict = $this->tca_access_verdict_factory->create( array(
			'status'  => $status,
			'reports' => $reports,
		) );
		$rules = $this->get_all_tca_rules();
		return $verdict;
	}

	/**
	 * Checks if the specified user can access the post
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access_post( UserInterface $user ) {
		$need_test = true;
		$status = false;
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $this->post_type );
		if (
			$tca_enabled === false ||
			count( (array) $this->tca_rules ) == 0
		) {
			$status = true;
			$need_test = false;
		}
		$reports = null;
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
	 * Checks if the terms associated with the post can be
	 * accessed by the specified user
	 * @param UserInterface $user User to test
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access_terms( UserInterface $user ) {
		$this->load( array( 'term' ) );
		$verdict = null;
		if ( $this->term && $this->term instanceof TermCollectionInterface ) {
			$verdict = $this->term->can_access( $user );
		}
		return $verdict;
	}

	/**
	 * Loads the term relation
	 * @param string[] $relations Further relations
	 * @return TermCollectionInterface
	 */
	protected function load_term( array $relations = array() ) {
		$term = $this->term_service->index( array(
			'id' => $this->ID,
		) );
		return $term;
	}
}
