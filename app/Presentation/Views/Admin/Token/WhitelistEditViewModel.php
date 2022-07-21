<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Token\WhitelistInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\WhitelistRepositoryInterface;

class WhitelistEditViewModel extends DynamicViewModel
	implements WhitelistEditViewModelInterface
{
	protected WhitelistInterface $whitelist;
	protected WhitelistRepositoryInterface $whitelist_repository;
	
	public function __construct(
		WhitelistRepositoryInterface $whitelist_repository
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
