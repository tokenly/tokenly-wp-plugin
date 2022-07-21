<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Application\Token\Access\CheckerService;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface;

use Tokenly\Wp\Collections\Token\Access\RuleCollectionCollection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermCheckerServiceInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Token\Access\VerdictInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class PostCheckerService extends CheckerService implements PostCheckerServiceInterface {
	protected PostRepositoryInterface $post_repository;
	protected TermCheckerServiceInterface $term_checker_service;

	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		TermCheckerServiceInterface $term_checker_service,
		PostRepositoryInterface $post_repository,
		UserRepositoryInterface $user_repository,
		TokenpassAPIInterface $client
	) {
		$this->post_repository = $post_repository;
		$this->term_checker_service = $term_checker_service;
		
		parent::__construct(
			$tca_settings_repository,
			$user_repository,
			$client
		);
	}

	/**
	 * @inheritDoc
	 */
	protected function get_tca_rules_relation(
		ProtectableInterface $target
	): RuleCollectionCollectionInterface {
		$post = $target;
		$rules = new RuleCollectionCollection();
		$post = $this->post_repository->load( $post, array( 'term' ) );
		if ( $post->term ) {
			$term_rules = $post->term->tca_rules;
			if (
				$term_rules &&
				count( ( array ) $term_rules ) > 0
			) {
				$rules->merge( $term_rules );
			}
		}
		return $rules;
	}

	/**
	 * @inheritDoc
	 */
	public function check_tca_enabled( ProtectableInterface $target ): bool {
		$post = $target;
		return $this->tca_settings->is_enabled_for_post_type(
			$post->post_type
		) ?? false;
	}

	/**
	 * @inheritDoc
	 */
	public function check_relations_protected(
		ProtectableInterface $target
	): bool {
		$post = $target;
		$terms_protected = false;
		$post = $this->post_repository->load( $post, array( 'term' ) );
		if ( $post->get_term() ) {
			$terms_protected = $this->term_checker_service->is_protected(
				$post->term
			);
		}
		if ( $terms_protected === true ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function test_access_relations(
		ProtectableInterface $target,
		?UserInterface $user = null ): ?VerdictInterface {
		$post = $target;
		$post = $this->post_repository->load( $post, array( 'term' ) );
		$verdict = null;
		if ( $post->term ) {
			$verdict = $this->term_checker_service->check(
				$post->term,
				$user
			);
		}
		return $verdict;
	}
}
