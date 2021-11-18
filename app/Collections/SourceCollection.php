<?php

/**
 * Collection of Source objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class SourceCollection extends Collection implements SourceCollectionInterface {
	protected $item_type = SourceInterface::class;
	protected $user_repository;

	public function __construct(
		array $items,
		UserRepositoryInterface $user_repository
	) {
		parent::__construct( $items );
		$this->user_repository = $user_repository;
	}
}
