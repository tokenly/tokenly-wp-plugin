<?php

namespace Tokenly\Wp\Services\Application\Token\Access;

use Tokenly\Wp\Services\Application\Token\Access\CheckerService;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermCheckerServiceInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Models\ModelInterface;
use Tokenly\Wp\Interfaces\Traits\ProtectableInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class TermCheckerService extends CheckerService implements TermCheckerServiceInterface {
	protected PostRepositoryInterface $post_repository;

	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		PostRepositoryInterface $post_repository,
		UserRepositoryInterface $user_repository,
		TokenpassAPIInterface $client
	) {
		$this->post_repository = $post_repository;
		parent::__construct( $tca_settings_repository, $user_repository, $client );
	}

	/**
	 * @inheritDoc
	 */
	public function check_tca_enabled( ProtectableInterface $target ): bool {
		$term = $target;
		$is_enabled = false;
		if ( $term instanceof CollectionInterface ) {
			foreach ( ( array ) $term as $item ) {
				$is_enabled = $this->check_tca_enabled( $item );
				if ( $is_enabled === true ) {
					return true;
				}
			}
			return $is_enabled;
		} elseif ( $term instanceof ModelInterface ) {
			$is_enabled = $this->tca_settings->is_enabled_for_taxonomy( $term->taxonomy ) ?? false;
		}
		return $is_enabled;
	}
}
