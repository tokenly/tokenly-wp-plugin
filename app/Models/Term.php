<?php

/**
 * WP_Term decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

class Term extends Model implements TermInterface {
	public $tca_rules;
	protected $term = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $tca_rule_collection_factory;
	protected $fillable = array(
		'term',
		'tca_rules',
	);

	public function __construct(
		TermRepositoryInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaSettingsInterface $tca_settings,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
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
	 * @return bool
	 */
	public function can_access_term( UserInterface $user ) {
		$can_access = $this->test_access( $user );
		return $can_access;
	}

	/**
	 * Check if the specified user is allowed to access the term
	 * @param UserInterface $user User to check
	 * @return bool
	 */
	protected function test_access( UserInterface $user ) {
		$term_id = $this->term_id;
		$can_access = false;
		$tca_enabled = $this->tca_settings->is_enabled_for_taxonomy( $this->taxonomy );
		if ( $tca_enabled === false ) {
			return true;
		}
		if ( count( (array) $this->tca_rules ) == 0 ) {
			return true;
		}
		$tca_allowed = $user->check_token_access( $this->tca_rules ) ?? false;
		return $tca_allowed;
	}
}
