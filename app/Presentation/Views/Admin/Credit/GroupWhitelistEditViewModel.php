<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupWhitelistEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupWhitelistRepositoryInterface;

class GroupWhitelistEditViewModel extends DynamicViewModel
	implements GroupWhitelistEditViewModelInterface
{
	protected GroupWhitelistInterface $whitelist;
	protected GroupWhitelistRepositoryInterface $whitelist_repository;
	
	public function __construct(
		GroupWhitelistRepositoryInterface $whitelist_repository
	) {
		$this->whitelist_repository = $whitelist_repository;
		$this->whitelist = $this->whitelist_repository->show();
	}
	
	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		$whitelist = $this->whitelist->to_array();
		return array(
			'whitelist' => $whitelist,
		);
	}
}
