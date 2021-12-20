<?php

/**
 * WP_Post decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\PostInterface;

use Tokenly\Wp\Interfaces\Collections\TcaAccessReportCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaAccessReportCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\GuestUserInterface;
use Tokenly\Wp\Interfaces\Models\TcaAccessReportInterface;
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
	protected $tca_rule_collection_factory;
	protected $term_service;
	protected $fillable = array(
		'post',
		'tca_rules',
	);

	public function __construct(
		PostRepositoryInterface $domain_repository,
		MetaRepositoryInterface $meta_repository,
		TcaAccessReportCollectionFactoryInterface $tca_access_report_collection_factory,
		TcaSettingsInterface $tca_settings,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		TermServiceInterface $term_service,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		$this->meta_repository = $meta_repository;
		$this->tca_settings = $tca_settings;
		$this->tca_access_report_collection_factory = $tca_access_report_collection_factory;
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
		if ( user_can( $user, 'administrator' ) ) {
			$user_status = true;
			$need_test = false;
		}
		if ( $user instanceof GuestUserInterface === true ) {
			$user_status = false;
			$need_test = false;
			$note = 'The user is not logged in.';
		}
		$user->load( array( 'oauth_user' ) );
		if ( !isset( $user->oauth_user ) ) {
			$user_status = false;
			$need_test = false;
			$note = 'The user is not connected.';
		}
		if ( $need_test ) {
			$access_verdict = $this->test_access( $user );
		} else {
			$access_verdict = array(
				'status'  => $user_status,
				'note'    => $note,
				'reports' => null,
			);
		}
		return $access_verdict;
	}

	/**
	 * Checks if the specified user can access the post and its terms
	 * @param UserInterface $user User to check
	 * @return TcaAccessReportCollectionInterface
	 */
	protected function test_access( UserInterface $user ) {
		$reports = $this->tca_access_report_collection_factory->create();
		$term_reports = $this->test_access_terms( $user );
		$post_report = $this->test_access_post( $user );
		if ( $term_reports instanceof TcaAccessReportCollectionInterface ) {
			$reports->merge( $term_reports );
		}
		if ( $post_report instanceof TcaAccessReportInterface ) {
			$reports[] = $post_report;
		}
		$status = $reports->can_pass();
		return array(
			'status'  => $status,
			'note'    => null,
			'reports' => $reports
		);
	}

	/**
	 * Checks if the specified user can access the post
	 * @param UserInterface $user User to check
	 * @return TcaAccessReportInterface
	 */
	protected function test_access_post( UserInterface $user ) {
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $this->post_type );
		if ( $tca_enabled === false ) {
			return;
		}
		if ( count( (array) $this->tca_rules ) == 0 ) {
			return;
		}
		$access_report = $user->check_token_access( $this->tca_rules );
		return $access_report;
	}

	/**
	 * Checks if the terms associated with the post can be
	 * accessed by the specified user
	 * @param UserInterface $user User to test
	 * @return TcaAccessReportCollectionInterface
	 */
	protected function test_access_terms( UserInterface $user ) {
		$this->load( array( 'term' ) );
		if ( !$this->term || !is_object( $this->term ) ) {
			return;
		}
		$access_reports = $this->term->can_access( $user );
		return $access_reports;
	}

	/**
	 * Loads the term relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_term( array $relations = array() ) {
		$terms = $this->term_service->index( array(
			'id' => $this->ID,
		) );
		if ( !$terms ) {
			return;
		}
		$this->term = $terms;
		return $this;
	}
}
