<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TermInterface;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaAccessVerdictFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

/**
 * WP_Term with some upgrades to support TCA
 */
class Term extends Model implements TermInterface {
	public $tca_rules;
	protected $term = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $tca_rule_collection_factory;
	protected $tca_access_verdict_factory;
	protected $fillable = array(
		'term',
		'tca_rules',
	);

	public function __construct(
		TermRepositoryInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaSettingsInterface $tca_settings,
		TcaAccessVerdictFactoryInterface $tca_access_verdict_factory,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
		$this->tca_access_verdict_factory = $tca_access_verdict_factory;
		parent::__construct( $data );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->term, $method ), $args );
	}

	public function __get( $key ) {
		return $this->term->$key;
	}

	public function __set( $key, $val ) {
		return $this->term->$key = $val;
	}

	/**
	 * Check if the specified user can access the term
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	public function can_access( UserInterface $user ) {
		$precheck = $user->get_tca_precheck_data();
		$verdict = null;
		if ( $precheck['need_test'] === true ) {
			$verdict = $this->test_access( $user );
		} else {
			$verdict = $precheck['verdict'];
		}
		return $verdict;
	}

	/**
	 * Check if the specified user is allowed to access the term
	 * @param UserInterface $user User to check
	 * @return TcaAccessVerdictInterface
	 */
	protected function test_access( UserInterface $user ) {
		$status = false;
		$need_test = true;
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $this->taxonomy );
		if ( $tca_enabled === false ) {
			$need_test = false;
			$status = true;
		}
		if ( $need_test === true ) {
			$verdict = $user->check_token_access( $this->tca_rules );
		} else {
			$verdict = $this->tca_access_verdict_factory->create( array(
				'status'  => $status,
				'reports' => null,
			) );
		}
		return $verdict;
	}
}
