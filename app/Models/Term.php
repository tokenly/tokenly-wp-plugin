<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Models\ProtectableInterface;
use Tokenly\Wp\Traits\ProtectableTrait;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

/**
 * WP_Term with some upgrades to support TCA
 */
class Term extends Model implements TermInterface, ProtectableInterface {
	use ProtectableTrait;

	public $tca_rules;
	protected $term = null;
	protected $meta_repository;
	protected $tca_settings;
	protected $fillable = array(
		'term',
		'tca_rules',
	);

	public function __construct(
		TermRepositoryInterface $domain_repository,
		PostMetaRepositoryInterface $meta_repository,
		TcaSettingsInterface $tca_settings,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
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

	/* Protectable trait */

	protected function check_tca_enabled() {
		$is_enabled = $this->tca_settings->is_enabled_for_taxonomy( $this->taxonomy ) ?? false;
		return $is_enabled;
	}
}
